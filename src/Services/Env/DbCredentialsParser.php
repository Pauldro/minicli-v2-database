<?php namespace Pauldro\Minicli\v2\Database\Services\Env;
use Exception;
// Minicli
use Minicli\App as MinicliApp;
use Minicli\ServiceInterface;
// Pauldro Minicli
use Pauldro\Minicli\v2\App\App;
use Pauldro\Minicli\v2\Database\Credentials;
use Pauldro\Minicli\v2\Services\Env;

/**
 * Parses Database Credentials from main app .env file
 */
class DbCredentialsParser implements ServiceInterface {
    const VARS = ['HOST', 'PORT', 'USER', 'PASSWORD', 'PROPEL.CONNECTION.NAME', 'PROPEL.ISDEFAULT', 'PROPEL.LIBRARY.NAME'];

    private Env $env;

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

    /**
     * Return Parsed Credentials
     * @param  string $prefix
     * @return Credentials
     */
    public function parse(string $prefix) : Credentials
    {
        $vars = [];

        foreach (self::VARS as $suffix) {
            $vars[] = "$prefix.$suffix";
        }

        $conf = new Credentials();
        $conf->name = $this->env->get("$prefix.NAME");
        $conf->host = $this->env->get("$prefix.HOST");
        $conf->port = $this->env->get("$prefix.PORT");
        $conf->user = $this->env->get("$prefix.USER");
        $conf->password = $this->env->get("$prefix.PASSWORD");
        $conf->propelName = $this->env->get("$prefix.PROPEL.CONNECTION.NAME"); 
        $conf->isPropelDefault = $this->env->getBool("$prefix.PROPEL.ISDEFAULT");

        if ($this->env->exists("$prefix.PROPEL.LIBRARY.NAME")) {
            $conf->propelLoadDatabaseFilepath = '@cptechinc/' . $this->env->get("$prefix.PROPEL.LIBRARY.NAME") . '/load/loadDatabase.php';
        }
        return $conf;
    }
}