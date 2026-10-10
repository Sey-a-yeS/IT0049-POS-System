<?php

namespace App\Commands;

use App\Models\UserModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SetUserPassword extends BaseCommand
{
    protected $group = 'Authentication';
    protected $name = 'auth:set-password';
    protected $description = 'Securely sets a password hash for one or all existing staff users.';
    protected $usage = 'auth:set-password [username] [--all]';
    protected $arguments = [
        'username' => 'The existing staff username whose password should be set.',
    ];
    protected $options = [
        '--all' => 'Prompt separately for every existing staff user.',
    ];

    public function run(array $params): int
    {
        if (! function_exists('stream_isatty') || ! stream_isatty(STDIN)) {
            CLI::error('Run this command in an interactive terminal so passwords can be entered without echoing.');

            return EXIT_ERROR;
        }

        $userModel = new UserModel();
        $setAll    = array_key_exists('all', $params) || CLI::getOption('all') === true;
        $username  = trim((string) (array_shift($params) ?? ''));

        if ($setAll && $username !== '') {
            CLI::error('Provide either a username or --all, not both.');

            return EXIT_ERROR;
        }

        if ($setAll) {
            $users = $userModel
                ->select('id, username')
                ->orderBy('id', 'ASC')
                ->findAll();
        } else {
            if ($username === '') {
                $username = trim(CLI::prompt('Existing username', null, 'required|max_length[50]'));
            }

            $user  = $userModel->select('id, username')->where('username', $username)->first();
            $users = $user === null ? [] : [$user];
        }

        if ($users === []) {
            CLI::error('No matching staff user was found.');

            return EXIT_ERROR;
        }

        CLI::write('Passwords are entered privately and are never printed or stored as plaintext.', 'yellow');

        foreach ($users as $user) {
            $password = $this->promptForPassword((string) $user['username']);
            $hash     = password_hash($password, PASSWORD_DEFAULT);

            $userModel->update((int) $user['id'], ['password' => $hash]);
            CLI::write('Password hash updated for ' . $user['username'] . '.', 'green');

            unset($password, $hash);
        }

        return EXIT_SUCCESS;
    }

    private function promptForPassword(string $username): string
    {
        while (true) {
            $password = $this->readSecret("New password for {$username}");

            if (strlen($password) < 12) {
                CLI::error('Use at least 12 characters.');
                continue;
            }

            $confirmation = $this->readSecret('Confirm password');

            if (! hash_equals($password, $confirmation)) {
                CLI::error('The passwords did not match. Please try again.');
                continue;
            }

            unset($confirmation);

            return $password;
        }
    }

    private function readSecret(string $prompt): string
    {
        fwrite(STDOUT, $prompt . ': ');
        shell_exec('stty -echo');

        try {
            $value = fgets(STDIN);
        } finally {
            shell_exec('stty echo');
            fwrite(STDOUT, PHP_EOL);
        }

        return rtrim((string) $value, "\r\n");
    }
}
