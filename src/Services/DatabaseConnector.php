<?php namespace Pauldro\Minicli\v2\Database\Services;

use Exception;
// Minicli
use Minicli\App as MinicliApp;
use Minicli\ServiceInterface;
// Pauldro Minicli
use Pauldro\Minicli\v2\App\App;
use Pauldro\Minicli\v2\Database\Credentials;
use Pauldro\Minicli\v2\Database\Database;
use Pauldro\Minicli\v2\Database\Exceptions\ConnectionFailureException;
use Pauldro\Minicli\v2\Services\Env;
use Pauldro\Minicli\v2\Util\SessionVars;

/**
 * @property Env $env
 */
class DatabaseConnector implements ServiceInterface {
    /**
     * load
     * @param  App  $app
     * @throws Exception
     * @return void
     */
    public function load(MinicliApp $app) : void
    {
        $this->env = $app->dotenv;
    }

    public function connect(string $name, Credentials $credentials) : void
    {
        $db = new Database($credentials);

        if ($db->connect() === false) {
            $msg = $db->errorMsg ? $db->errorMsg : "Failed to connect to $name Database";
            throw new ConnectionFailureException($msg);
        }
        SessionVars::setFor('databases', $name, $db);
    }
}