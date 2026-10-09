<?php

namespace App\Commands;

use App\Models\UserModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SetUserPassword extends BaseCommand
{
    protected $group = 'Authentication';
    protected $name = 'auth:set-password';
    protected $description = 'Securely sets a password hash for an existing demo user.';
    protected $usage = 'auth:set-password [username]';
    protected $arguments = [
        'username' => 'The existing username whose password should be set.',
    ];

    public function run(array $params): int
    {
        if (! function_exists('stream_isatty') || ! stream_isatty(STDIN) || ! function_exists('shell_exec')) {
            CLI::error('Run this command in an interactive terminal so the password can be entered without echoing.');

            return EXIT_ERROR;
        }

        $username = trim((string) (array_shift($params) ?? ''));

        if ($username === '') {
            $username = trim(CLI::prompt('Existing username', null, 'required|max_length[50]'));
        }

        $userModel = new UserModel();
        $user      = $userModel->select('id, username')->where('username', $username)->first();

        if ($user === null) {
            CLI::error('No matching demo user was found.');

            return EXIT_ERROR;
        }

        CLI::write('The password is entered privately and is never printed or stored as plaintext.', 'yellow');
        $password = $this->promptForPassword((string) $user['username']);
        $hash     = password_hash($password, PASSWORD_DEFAULT);

        $userModel->update((int) $user['id'], ['password' => $hash]);
        CLI::write('Password hash updated for ' . $user['username'] . '.', 'green');

        unset($password, $hash);

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
