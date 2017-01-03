@api
Feature: Blog admin
  In order to maintain the blog posts of the site
  As an admin user
  I need to be able to add/edit/delete blog posts

  Scenario: Make sure the blog post content type is available
    Given I am logged in as a user with the "create blog_post content" permission
    When I visit "/node/add/blog_post"
    Then I should see "Create Blog post"

  Scenario: Access the blog posts admin page
    Given I am logged in as a user with the "Administer content" permission
    When I visit "/admin/content/blog"
    Then I should see "Blog Posts"
