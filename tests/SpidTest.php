<?php
declare(strict_types=1);

require_once(__DIR__ . "/../vendor/autoload.php");

final class SpidTest extends PHPUnit\Framework\TestCase
{
    public function testCanBeCreatedFromValidSettings(): void
    {
        $base = "https://sp2.simevo.com";
        $settings = [
            'spEntityId' => $base,
            'spAcsUrl' => $base . "/acs.php",
            'spSloUrl' => $base . "/logout.php",
            'spKeyFile' => "./example/sp.key",
            'spCrtFile' => "./example/sp.crt",
            'idpMetadataFolderPath' => "./example/idp_metadata",
            'idpList' => array('testenv2')
        ];
        $this->assertInstanceOf(
            Italia\Spid2\Sp::class,
            new Italia\Spid2\Sp($settings)
        );
        session_destroy();
    }

    private function validateXml($xmlString, $schemaFile, $valid = true): void
    {
        $xml = new DOMDocument();
        $xml->loadXML($xmlString, LIBXML_NOBLANKS);
        $this->assertEquals($xml->schemaValidate($schemaFile), $valid);
    }

    public function testMetatadaValid(): void
    {
        session_name('s2');
        $base = "https://sp2.simevo.com";
        $settings = [
            'spEntityId' => $base,
            'spAcsUrl' => $base . "/acs.php",
            'spSloUrl' => $base . "/logout.php",
            'spKeyFile' => "./example/sp.key",
            'spCrtFile' => "./example/sp.crt",
            'idpMetadataFolderPath' => "./example/idp_metadata",
            'idpList' => array('testenv2')
        ];
        $spid = new Italia\Spid2\Sp($settings);
        $metadata = $spid->getSPMetadata();
        $this->validateXml($metadata, "./tests/schemas/saml-schema-metadata-SPID-SP.xsd");
        session_destroy();
    }
}
