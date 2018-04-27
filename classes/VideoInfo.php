<?php
/**
 * Get information of video represented by Video or VideoSource entity
 */

class VideoInfo extends VideoShellAPI {
	private $fileinfo;
       // public $filenamenow = getFilenameOnFilestore();
	public function __construct(ElggObject $video) {
		parent::__construct();
		$this->setInputfile($video->getFilenameOnFilestore());
		$this->fileinfo = $this->execute();
		
	}

	/**
	 * Get video resolution on format 1920x1080
	 *
	 * @return string
	 */
	public function getResolution() {
	       //TM: /Video: does not return anything cos not in the file instade I used  /from
		preg_match('/Video: .*\n/', $this->fileinfo, $matches); 
		preg_match('/[0-9]{1,4}x[0-9]{1,4}/', $matches[0], $matches);
		return $matches[0];
	}

	/**
	 * Get video duration in format HH:MM:SS
	 *
	 * @return string
	 */
	public function getDuration() {
		preg_match('/Duration: [0-9]{2}:[0-9]{2}:[0-9]{2}/', $this->fileinfo, $matches);
		preg_match('/[0-9]{2}:[0-9]{2}:[0-9]{2}/', $matches[0], $matches);
		return $matches[0];
	}

	/**
	 * Get video bitrate in kilobits
	 *
	 * @return string
	 */
	public function getBitrate() {
		preg_match('/bitrate: [0-9]+ kb\/s/', $this->fileinfo, $matches);
		preg_match('/[0-9]+/', $matches[0], $matches);
		return $matches[0];
	}
	
	/*
	* TM: function
	* get the part after the last underscore
	*  get the filename without extenstion
	*
	* @return string  
	*/

	public function getInfoFilenameResolutionWithoutExtension() {
		// returns string(75) "from '/home/tmg/elggdata/1/36/video/677/20180205_102758_256x144.mp4': " 
		 $matchesFound =  preg_match('/from .*\n/', $this->fileinfo, $matches);
		// returns resolution in form of string(7) "256x144"
		 preg_match('/[0-9]{1,4}x[0-9]{1,4}/', $matches[0], $matches);
		 return $matches[0];
		 
	}
	
	
	
}