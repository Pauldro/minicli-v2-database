<?php namespace Pauldro\Minicli\v2\Database\Cmd;
use Exception;
// Pauldro Minicli
use Pauldro\Minicli\v2\Cmd\AbstractController as ParentController;
use Pauldro\Minicli\v2\Database\Credentials;
use Pauldro\Minicli\v2\Database\CredentialsEnvParser;
use Pauldro\Minicli\v2\Database\DatabaseConnector;
use Pauldro\Minicli\v2\Services\Env;
use Pauldro\Minicli\v2\Util\SessionVars;

/**
 * @property CredentialsEnvParser $dbCredentialsParser
 */
abstract class AbstractController extends ParentController {
    public function init() : bool
    {
        if (parent::init() === false) {
            return false;
        }
        $this->dbCredentialsParser = new CredentialsEnvParser($this->app->dotenv);
        return true;
    }

    /**
     * Initialize Database Connection
     * @param  string $name                  Connection Name
     * @param  string $envPrefix             Prefix in .env file
     * @param  array  $credentialsOverrides  Credential overrides values
     * @return bool
     */
    protected function initDatabasex(string $name, string $envPrefix, array $credentialsOverrides = []) {
        try {
            $conf = $this->dbCredentialsParser->parse($envPrefix);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

        foreach ($credentialsOverrides as $key => $value) {
            $conf->$key = $value;
        }

        $db = new DatabaseConnector($conf);

        if ($db->connect() === false) {
            $msg = $db->errorMsg ? $db->errorMsg : "Failed to connect to $name Database";
            return $this->error($msg);
        }
        SessionVars::setFor('databases', $name, $db);
        return true;
    }
}