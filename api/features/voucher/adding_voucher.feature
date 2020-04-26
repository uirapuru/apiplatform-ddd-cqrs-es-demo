@voucher
Feature: Adding a new voucher
  In order to let member enter activities
  As an Administrator
  I want to add a new voucher for member

  Background:
    Given there is user "John Doe" registered
    And I am logged in as an administrator

  Scenario: Adding a new paid voucher
    Given I want to create a new voucher
    When I sell it for user "John Doe"
    And I set its price to "10.00 PLN"
    And I specify that it was cash paid
    And I add it
    Then I should be notified that it has been successfully created
    And the new voucher should appear in the app
    And it should be active
    And the new payment for user "John Doe" should be created
    And the payment should be done.
