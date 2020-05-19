@managing_entries
Feature: Adding a new entry
  In order to let member enter activities
  As an Employee
  I want to add a new entry for a user

  Background:
    Given there is user "John Doe" registered
    And I am logged in as an employee
    And activity "Salsa" at "19:00" is added

  @domain
  Scenario: Adding a new entry for user with no voucher
    Given "John Doe" has no voucher
    When "John Doe" enters "Salsa"
    Then entry is added
    And created entry is "credit" type
    And he should be notified that entry was successfully created

  @domain
  Scenario: Adding a new entry for user having an active open voucher
    Given "John Doe" has an active "open" voucher
    When "John Doe" enters "Salsa"
    Then entry is added
    And created entry is "voucher" type
    And he should be notified that entry was successfully created

  @domain
  Scenario: Adding a new voucher for user having an active but full voucher

  @domain
  Scenario: Adding a new voucher for user having an active but for different activities voucher
