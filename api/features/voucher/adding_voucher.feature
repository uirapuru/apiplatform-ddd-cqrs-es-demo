@voucher
Feature: Adding a new voucher
  In order to let member enter activities
  As an Administrator
  I want to add a new voucher for member

  Background:
    Given there is user "John Doe" registered
    And I am logged in as an administrator

  Scenario: Adding a new voucher paid by cash
    When I sell it to user "John Doe"
    And I set its price to "10.00 PLN"
    And customer paid for it
    And I add it
    Then he should be notified that voucher has been successfully created
    And the new voucher should appear in the app
    And the new order for user "John Doe" should be created
    And it should be paid
    And the new payment for user "John Doe" should be created
    And the payment should be done.

  Scenario: Adding a new voucher
    When I sell it to user "John Doe"
    And I set its price to "10.00 PLN"
    And customer did not paid for it
    And I add it
    Then he should be notified that voucher has been successfully created
    And the new voucher should appear in the app
    And the new order for user "John Doe" should be created
    And the order should be 'new' status
    And the new payment for user "John Doe" should be created
    And the payment should be 'waiting' status

  Scenario: Paying by transfer a voucher
    Given an order for voucher is placed for user "John Doe"
    When customer made a payment for it
    Then he should be notified that voucher has been successfully created
    And voucher should be active

  Scenario: Rejecting a payment
    Given an order for voucher is placed for user "John Doe"
    And the new order for user "John Doe" should be created
    And the new payment for user "John Doe" should be created
    When customer rejects the payment
    Then he should be notified that voucher has been rejected
    And voucher should be inactive
    And voucher should be closed
    And the order should be 'rejected' status
    And the payment should be 'rejected' status
