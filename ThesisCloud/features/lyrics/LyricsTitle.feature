Feature: Lyrics Title
	Users should be able to see the
	song title of the lyrics shown

	Scenario: REQ-1: Upon, initialization, the text area contains the lyrics of the song with thish the Lyrics feature is initialized
		Given I am on SongListPage 
		Given the song list is for "don't" 
		And the artists are "Rebecca Black" 
		When I press on the song "Friday"
		Then I am on LyricsPage
		And the header should contain “Friday by Rebecca Black”

	Scenario: REQ-1 (two artists): Upon, initialization, the text area contains the lyrics of the song with thish the Lyrics feature is initialized
		Given I am on SongListPage 
		Given the song list is for "don't" 
		And the artists are "Rebecca Black" and "Swedish House Mafia"
		When I press on the song "Friday"
		Then I am on LyricsPage
		And the header should contain “Friday by Rebecca Black”