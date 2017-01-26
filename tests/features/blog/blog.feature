Feature: Blog
  In order to read blog posts
  As a site user
  I need to be able to see the blog posts

  Background:
    Given I am on "/"

  Scenario: View the News & Blog block on the front page
    Then I should see "Blog" in the "navigation" region
    Then I should see "News & Blog" in the "content" region
    And I should see "See more news"

  Scenario: Access the blog landing page via the Blog menu link
    When I click "Blog"
    Then I should be on "/blog"
    And I should see "Blog"

  Scenario: View the blog post view on the Blog page
    When I click "Blog"
    Then the ".view--blog-posts--blog" element should contain "Sea lettuce napa cabbage celery groundnut green"
