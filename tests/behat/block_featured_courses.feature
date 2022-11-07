@block @block_featured_courses
Feature: Add a featured block on the dashboard
  I can add completion block to the dashboard and set the courses as featured

  Background:
    And the following "courses" exist:
      | fullname | shortname | category | enablecompletion |
      | Course 1 | C1        | 0        | 1                |
      | Course 2 | C2        | 0        | 1                |
      | Course 3 | C3        | 0        | 1                |
      | Course 4 | C4        | 0        | 1                |

  @javascript
  Scenario: Add the block and set 3 featured courses
    Given I log in as "admin"
    Then I am on homepage
    When I press "Customise this page"
    And I add the "Featured Courses" block
    And I configure the "Featured courses" block
    And I expand all fieldsets
    Then I should see "Title"
    And I set the field "Title" to "My featured courses"
    And I press "Add 3 more courses"
    Then I set the following fields to these values:
    | Selected course 1 | Course 1 |
    | Selected course 2 | Course 2 |
    | Selected course 3 | Course 3 |
    And I set the field "Region" to "content"
    And I press "Save changes"
    Then I should see "Course 1" in the "My featured courses" "block"
    Then I should see "Course 2" in the "My featured courses" "block"
    Then I should see "Course 3" in the "My featured courses" "block"

  @javascript
  Scenario: Add the block and set 3 featured courses and remove one after, only two should display
    Given I log in as "admin"
    When I press "Customise this page"
    Then I add the "Featured courses" block
    And I configure the "Featured courses" block
    And I expand all fieldsets
    Then I should see "Title"
    And I set the field "Title" to "My featured courses"
    And I press "Add 3 more courses"
    Then I set the following fields to these values:
      | Selected course 1 | Course 1 |
      | Selected course 2 | Course 2 |
      | Selected course 3 | Course 3 |
      | Selected course 4 | Course 4 |
    And I set the field "Region" to "content"
    And I press "Save changes"
    Then I should see "Course 1" in the "My featured courses" "block"
    Then I should see "Course 2" in the "My featured courses" "block"
    Then I should see "Course 3" in the "My featured courses" "block"
    Then I should see "Course 4" in the "My featured courses" "block"
    Then I configure the "My featured courses" block
    And I press "Remove last course"
    And I press "Save changes"
    Then I should see "Course 1" in the "My featured courses" "block"
    Then I should see "Course 2" in the "My featured courses" "block"
    Then I should see "Course 3" in the "My featured courses" "block"
    Then I should not see "Course 4" in the "My featured courses" "block"
