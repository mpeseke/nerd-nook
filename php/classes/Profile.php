<?php


/**
 * Class Profile
 *
 * This data is representative of the stored data for a NerdNook Profile
 *
 * @author Ryan Becker <rbecker8@cnm.edu>
 * @version 1.0
 **/

class Profile {
	use ValidateUuid;
	/**
	 * id for Profile; this is a primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;
	/**
	 * token handed out to verify that the profile is valid and not malicious
	 * @var $profileActivationToken;
	 **/
	private $profileActivationToken;
	/**
	 * at handle for this Profile; this is a unique index
	 * @var string $profileAtHandle
	 *
	 **/
	private $profileAtHandle;
	/**
	 * email for this Profile; this is a unique index
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * hash for profile password
	 * @var $profileHash
	 **/






}