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

  @javascript
  Scenario: Create blog post
    Given I am logged in as a user with the "create blog_post content" permission
    When I visit "/node/add/blog_post"
    And I fill in "Title" with "Hello World"
    And I fill in "Body" ckeditor field with "Lipsum dolor sit amet."
    And I press "Save"
    Then I should see "Blog post Hello World has been created."
