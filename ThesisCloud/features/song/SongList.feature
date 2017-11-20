Feature: Song List
	In order to prove that the song list works
	on the song page, we need to test that each of its
	pieces work as intentended. 

	Scenario: REQ-1, REQ-2, REQ-3
		Given I am on the WordCloudPage
		And the header should contain “Rebecca Black”
		When I click word “don't” from the cloud
		Then I am on SongListPage
		And the song list contains:
			| title            | frequency |
			| We Can't Stop    | 7         |
			| Saturday         | 5         |
			| The Great Divide | 3         |
			| In Your Words    | 2         |
			| Friday           | 1         |
			| My Moment        | 1         |

	Scenario: REQ-1, REQ-2, REQ-3 (two artists)
		Given I am on the WordCloudPage
		And the header should contain “Rebecca Black” and "Swedish House Mafia"
		When I click word “don't” from the cloud
		And the song list contains:
			| title            		| frequency |
			| Don't You Worry Child | 16		|
			| We Can't Stop 		| 7			|
			| Saturday				| 5			|
			| The Great Divide		| 3			|
			| Antidote   			| 2			|
			| In Your Words			| 2			|
			| Friday				| 1			|
			| My Moment				| 1			|