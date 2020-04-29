@voucher
Feature: Adding a new voucher
  In order to let member enter activities
  As an Administrator
  I want to add a new voucher for member

  Background:
    Given there is user "John Doe" registered
    And I am logged in as an administrator

  Scenario: Adding a new voucher
    When I place order for voucher
    And I sell it to user "John Doe"
    And I set its price to "10.00 PLN"
    And customer paid for it
    Then I should be notified that voucher has been successfully created
    And the new voucher should appear in the app
    And the new order for user "John Doe" should be created
    And it should be paid
    And the new payment for user "John Doe" should be created
    And the payment should be done.
