@managing_entries
Feature: Adding a new entry
  In order to let member enter activities
  As an Employee
  I want to add a new entry for a user

  Background:
    Given there is user "John Doe" registered
    And I am logged in as an employee
    And activity "Salsa" at "19:00" is added

#  @domain
#  Scenario: Adding a new voucher for user with no voucher
#    When
