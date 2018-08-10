<?php
namespace Spid;

use Spid\Interfaces\SpInterface;
use Spid\Strategy\SpOneLogin;

class Sp implements SpInterface
{

    private $strategy = null;
    private $mode = null;
    private $settings = null;

    public function __construct($settings = null, $mode = 'onelogin')
    {
        session_start();
        $this->mode = $mode;
        $this->settings = $settings;

        $this->initStrategy();
    }

    private function initStrategy($idpName = null)
    {
        switch ($this->mode) {
            case 'onelogin':
                $this->strategy = new SpOneLogin($this->settings, $idpName);
                break;
            default:
                $this->strategy = new SpOneLogin($this->settings, $idpName);
                break;
        }
    }

    public function getSPMetadata()
    {
        return $this->strategy->getSPMetadata();
    }

    public function getSupportedIdps()
    {
        return $this->strategy->getSupportedIdps();
    }

    public function isAuthenticated()
    {
        return $this->strategy->isAuthenticated();
    }

    public function login($idpName, $redirectTo = '', $level = 1)
    {
        if (is_null($this->strategy)) {
            $this->initStrategy($idpName);
        }
        return $this->strategy->login($idpName, $redirectTo);
    }
    
    public function logout()
    {
        return $this->strategy->logout();
    }

    public function getAttributes()
    {
        return $this->strategy->getAttributes();
    }
}
