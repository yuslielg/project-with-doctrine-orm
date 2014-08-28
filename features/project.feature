@project
Feature: Manage projects

    Background:
        Given there are the following projects:
            | strid       | name      |
            | project-1   | Project 1 |
            | project-2   | Project 2 |
            | project-3   | Project 3 |

    Scenario: Picking a project using a identifier
        When I pick the project "project-2"
        Then I should get the following project:
            | strid   | project-2 |

    Scenario: Collecting projects
        When I collect projects
        Then I should get the following projects:
            | strid       |
            | project-1   |
            | project-2   |
            | project-3   |

    Scenario: Adding a project
        When I add the following project:
            | strid | project-4 |
            | name  | Project 4 |
        And I collect projects
        Then I should get the following projects:
            | strid       |
            | project-1   |
            | project-2   |
            | project-3   |
            | project-4   |

    Scenario: Removing a project
        When I pick the project "project-2"
        And I remove the picked project
        And I collect projects
        Then I should get the following projects:
            | strid       |
            | project-1   |
            | project-3   |