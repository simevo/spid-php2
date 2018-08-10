<?php

namespace Italia\Spid2\Interfaces;

interface SpInterface
{
    public function getSPMetadata();
    public function getSupportedIdps();
    public function isAuthenticated();
    public function login($idpName, $redirectTo = '', $level = 1);
    public function logout();
    public function getAttributes();
}
