Feature: Lyrics Page
	In order to prove that the lyrics page works, 
	we need to test that each of its pieces work as intentended. 

Scenario: REQ-1: Upon initialization, the text area contains the lyrics of the song with which the Lyrics feature is initialized.
	Given I am on SongListPage 
	And the "artist" is "Taylor Swift"
	And the header contains “daydream”
	And I press the song “STYLE (1)”
	Then I am on LyricsPage

Scenario: REQ-1-2: Upon initialization, the text area contains the lyrics of the song with which the Lyrics feature is initialized.
	Given I am on SongListPage 
	And the artist are "Taylor Swift" and "Swedish House Mafia"
	And the header contains “love”
	And I press the song “YOU'RE IN LOVE (1)”
	Then I am on LyricsPage

Scenario: REQ-2: Throughout the lyrics on the Lyrics Page, any occurrences of the word with which the Lyrics feature was initialized should be highlighted in yellow.
	Given I am on LyricsPage 
	And the "song" is “STYLE”
	And the "word" is "MIDNIGHT"
	Then occurrences of "MIDNIGHT" should be highlighted in yellow


