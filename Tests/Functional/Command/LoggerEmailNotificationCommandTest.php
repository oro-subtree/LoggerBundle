<?php

namespace Oro\Bundle\LoggerBundle\Tests\Functional\Command;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

/**
 * @dbIsolation
 */
class LoggerEmailNotificationCommandTest extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->initClient();
    }

    public function testRunCommand()
    {
        $params = ['--recipients="recipient1@example.com;recipient2@example.com"'];
        $result = $this->runCommand('oro:logger:email-notification', $params);

        $this->assertContains('', $result);
    }

    public function testRunCommandWithFailedValidation()
    {
        $params = ['--recipients="recipient1@example.com;not_valid_email'];
        $result = $this->runCommand('oro:logger:email-notification', $params);

        $this->assertContains('not_valid_email - This value is not a valid email address.', $result);
    }

    public function testRunCommandToDisableNotifications()
    {
        $configGlobal = $this->getContainer()->get('oro_config.global');
        $configGlobal->set('oro_logger.email_notification_recipients', 'recipient1@example.com');
        $params = ['--disable'];

        $result = $this->runCommand('oro:logger:email-notification', $params);
        $expectedContent = "Error logs notification successfully disabled.";
        $this->assertContains($expectedContent, $result);
        $this->assertEquals('', $configGlobal->get('oro_logger.email_notification_recipients'));

        $result = $this->runCommand('oro:logger:email-notification', $params);
        $expectedContent = "Error logs notification already disabled.";
        $this->assertContains($expectedContent, $result);
        $this->assertEquals('', $configGlobal->get('oro_logger.email_notification_recipients'));
    }

    public function testCommandContainsHelp()
    {
        $result = $this->runCommand('oro:logger:email-notification', ['--help']);

        $this->assertContains("Usage:\n  oro:logger:email-notification [options]", $result);
    }
}
