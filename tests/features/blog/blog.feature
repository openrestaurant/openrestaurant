Feature: Blog
  In order to read blog posts
  As a site user
  I need to be able to see the blog posts

  Scenario: Access the blog landing page via the Blog menu link
    Given I am on "/"
    When I click "Blog"
    Then I should see "Blog"

