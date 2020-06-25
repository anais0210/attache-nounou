@nanny
Feature: Nanny feature, create, update, delete

  Scenario: Creation of an nanny
    When  I send POST request to "/attache-nounou/nanny/create" with filename "test/Behat/Nanny/create_succes_nanny.json"
    Then the response status code should be 201

