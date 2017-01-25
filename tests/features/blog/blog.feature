Feature: Blog
  In order to read blog posts
  As a site user
  I need to be able to see the blog posts

  Scenario: Access the blog landing page via the Blog menu link
    Given I am on "/"
    When I click "Blog"
    Then I should see "Blog"

  Scenario: View the News & Blog block on the front page
    Given I am on "/"
    Then I should see "Blog" in the "navigation" region
    Then I should see "News & Blog"
    And I should see "See more news"
