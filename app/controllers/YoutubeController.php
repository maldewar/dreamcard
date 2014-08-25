<?php

class YoutubeController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
  }

  public function search() {
    $client = new Google_Client();
    $client->setDeveloperKey('AIzaSyBpfu7Aqx8dLsp_Zce0Kj6RXJa1YraCNF4');
    $youtube = new Google_Service_YouTube($client);
    $htmlBody = '';
    $videos = '';
    $page_token = '';
    $video_ids = array();
    $video_entities = array();
    $video_views = array();
    $search_params = array('q' => 'my daughter singing', 'maxResults' => 50);
    if (isset($_GET['page_token'])) {
      $search_params['pageToken'] = $_GET['page_token'];
    }
    try {
      // Call the search.list method to retrieve results matching the specified
      // query term.
      $searchResponse = $youtube->search->listSearch('id,snippet', $search_params);
      // Add each result to the appropriate list, and then display the lists of
      // matching videos, channels, and playlists.
      foreach ($searchResponse['items'] as $searchResult) {
        switch ($searchResult['id']['kind']) {
          case 'youtube#video':
            $videos .= sprintf('<li>%s (%s)</li>',
            $searchResult['snippet']['title'], $searchResult['id']['videoId']);
            $ytResult = new YtResult;
            $ytResult->video_id = $searchResult['id']['videoId'];
            $ytResult->url = 'http://www.youtube.com/watch?v=' . $searchResult['id']['videoId'];
            $ytResult->title = $searchResult['snippet']['title'];
            $ytResult->username = $searchResult['snippet']['channelTitle'];
            $ytResult->user_id = $searchResult['snippet']['channelId'];
            $ytResult->user_url = 'http://www.youtube.com/channel/' . $searchResult['snippet']['channelId'];
            $ytResult->published_at = $searchResult['snippet']['publishedAt'];
            $ytResult->thumb = $searchResult['snippet']['thumbnails']->getHigh()->url;
            $video_entities[$ytResult->video_id] = $ytResult;
            array_push($video_ids, $searchResult['id']['videoId']);
            break;
        }
      }

      $viewsResponse = $youtube->videos->listVideos("statistics", array('id' => implode(',',$video_ids)));
      foreach ($viewsResponse['items'] as $viewResult) {
        $video_views[$viewResult['id']] = $viewResult['statistics']['viewCount'];
      }

      foreach ($video_entities as $video_id => $video_entity) {
        $video_entity->views = $video_views[$video_id];
        //$video_entity->save();
      }
      $page_token = $searchResponse['nextPageToken'];
    } catch (Google_ServiceException $e) {
      $videos .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
      $videos .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
    }
    return View::make('site/yt/search',array('result' => $videos, 'page_token' => $page_token, 'video_ids' => $video_ids));
  }

}
