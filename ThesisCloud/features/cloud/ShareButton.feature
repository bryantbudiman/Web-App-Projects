Feature: Share Button
	In order to prove that the share button works
	on the cloud page, we need to test that each of its
	pieces work as intended. 

Scenario: REQ-1: Upon clicking the Share Button, the user is redirected to the Facebook website with the action of creating a new post.
	Given I am on the WordCloudPage
	And the header should contain “Taylor Swift”
	And I press "shareToFBButton"
	Then I should see Facebook page

Scenario: REQ-1: Upon clicking the Share Button, the user is redirected to the Facebook website with the action of creating a new post.
	Given I am on the WordCloudPage
	And the headers should contain “Taylor Swift, Justin Bieber”
	And I press "shareToFBButton"
	Then I should see Facebook page

Scenario: REQ-2: The post consists of an image of the word cloud and name(s) of the included artist(s).
	Given I am on the WordCloudPage
	And I press "shareToFBButton"
	Then the image of the cloud shared to my Facebook profile 

Scenario: REQ-3: Any logging in, etc. is handled by the Facebook website.
	Given I am on the WordCloudPage
	And I press "shareToFBButton"
	Then I should be logged in to my Facebook profile

