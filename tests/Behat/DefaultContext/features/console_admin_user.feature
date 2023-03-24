# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature:
    In order to prove that the application is correctly installed
    As a console user
    I want to create an administrator account

    Scenario: It has a command to create an administrator account
        When I run "bin/console"
        Then I should see "app:administrator:create" in the output
        Then I should see "Add a user as administrator" in the output

    Scenario: It create an administrator account
        Given There are no administrator account in the system
        When I run "bin/console app:administrator:create demotest@example.com 123456"
        Then I should see "[OK] New Admin user was created." in the output
        Then I should see "[INFO] User login email: demotest@example.com" in the output

