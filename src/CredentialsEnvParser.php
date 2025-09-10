<?php namespace Pauldro\Minicli\v2\Database;
// Pauldro Minicli
use Pauldro\Minicli\v2\Exceptions\MissingEnvVarsException;
use Pauldro\Minicli\v2\Services\Env;

/**
 * @property Env $env
 */
class CredentialsEnvParser {
    const SUFFIXES = ['HOST', 'PORT', 'USER', 'PASSWORD', 'PROPEL.CONNECTION.NAME', 'PROPEL.ISDEFAULT', 'PROPEL.LIBRARY.NAME'];

    public function __construct(Env $env) {
        $this->env = $env;
    }

    /**
     * Return Parsed Credentials
     * @param  string $prefix
     * @throws MissingEnvVarsException
     * @return Credentials
     */
    public function parse(string $prefix) : Credentials
    {
        $vars = [];

        foreach (self::SUFFIXES as $suffix) {
            $vars[] = "$prefix.$suffix";
        }

        $this->env->required($vars);

        $conf = new Credentials();
        $conf->name = $this->env->get("$prefix.NAME");
        $conf->host = $this->env->get("$prefix.HOST");
        $conf->port = $this->env->get("$prefix.PORT");
        $conf->user = $this->env->get("$prefix.USER");
        $conf->password = $this->env->get("$prefix.PASSWORD");
        $conf->propelName = $this->env->get("$prefix.PROPEL.CONNECTION.NAME"); 
        $conf->isPropelDefault = $this->env->getBool("$prefix.PROPEL.ISDEFAULT");
        $conf->propelLoadDatabaseFilepath = '@cptechinc/' . $this->env->get("$prefix.PROPEL.LIBRARY.NAME") . '/load/loadDatabase.php';
        return $conf;
    }
}