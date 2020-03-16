<?php
namespace Vendor\PHPList;

/**
 * 
 * Class phpListRESTApiClient.
 * 
 */

/**
 * 
 * example PHP client class to access the phpList Rest API.
 * License: MIT, https://opensource.org/licenses/MIT
 * 
 * To use this class, you need the restapi plugin for phpList, https://resources.phplist.com/plugin/restapi
 * Set the parameters below to match your system:
 * 
 * - url                    : URL of your phpList installation
 * - loginName              : admin login
 * - password               : matching password
 * - remoteProcessingSecret : (optional) the secret as defined in your phpList settings
 * 
 * v 1.01 Nov 26, 2015 added optional secret on instantiation
 * v 1 * Michiel Dethmers, phpList Ltd, November 18, 2015
 *    Initial implementation of basic API calls
 */
class PhpListApiClient
{

    /**
     * Curl Object to make request
     * @var object
     */
    private $curl;

    /**
     * URL of the API to connect to including the path
     * generally something like.
     * 
     * https://website.com/lists/admin/?pi=restapi&page=call
     */
    private $url;

    /**
     * login name for the phpList installation.
     */
    private $loginName;

    /**
     * password to login.
     */
    private $password;

    /**
     * the path where we can write our cookiejar.
     */
    public $tmpPath = '/tmp';

    /**
     * optionally the remote processing secret of the phpList installation
     * this will increase the security of the API calls.
     */
    private $remoteProcessingSecret;

    /**
     * construct, provide the Credentials for the API location.
     * 
     * @param string $url URL of the API
     * @param string $loginName name to login with
     * @param string $password password for the account
     * @return null
     */
    public function __construct($url, $loginName, $password, $secret = '')
    {
        $this->url = $url;

        $this->loginName = $loginName;
        $this->password = $password;
        $this->remoteProcessingSecret = $secret;

        $this->login();
    }

    public function __call($name, $arguments)
    {
        if (strpos($name, 'call') !== 0) {
            throw new \Exception('Method not found !');
        };

        return $this->callApi(lcfirst(str_replace('call', '', $name)), $arguments[0] ?? [], false);
    }

    private function prepareCurl()
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->tmpPath . '/phpList_RESTAPI_cookiejar.txt');
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->tmpPath . '/phpList_RESTAPI_cookiejar.txt');
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Connection: Keep-Alive', 'Keep-Alive: 60'));

        return $this;
    }

    /**
     * Make a call to the API using cURL.
     * 
     * @param string $command The command to run
     * @param array $post_params Array for parameters for the API call
     * @param bool $decode json_decode the result (defaults to true)
     *
     * @return string result of the CURL execution
     */
    private function callApi($command, $post_params, $decode = true, $newSession = false)
    {
        $post_params['cmd'] = $command;

        // optionally add the secret to a call, if provided
        if (!empty($this->remoteProcessingSecret)) {
            $post_params['secret'] = $this->remoteProcessingSecret;
        }
        $post_params = http_build_query($post_params);
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->url);
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $post_params);
        curl_setopt($c, CURLOPT_COOKIEFILE, $this->tmpPath . '/phpList_RESTAPI_cookiejar.txt');
        curl_setopt($c, CURLOPT_COOKIEJAR, $this->tmpPath . '/phpList_RESTAPI_cookiejar.txt');
        curl_setopt($c, CURLOPT_COOKIESESSION, $newSession); // Fix for random failed authentication
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Connection: Keep-Alive', 'Keep-Alive: 300'));

        // Execute the call
        $response = $result = curl_exec($c);
//        pr($response);

        // Check if decoding of result is required
        if ($decode === true) {

            $result = json_decode($result);
            if(!isset($result->status)){
                $this->logout();
                redirect(CURRENT_URL);
                exit;
            }

            if (json_last_error() !== JSON_ERROR_NONE && DEVELOPMENT) {
                throw new \Exception($response);
            }

            if ($result->status === 'error' && DEVELOPMENT) {
                throw new \Exception('<b>PHPLIST INTERNAL ERROR :</b><br>' . ($result->data->message ?? $result->data ?? $result));
            }
        }

        return $result;
    }

    /**
     * Use a real login to test login api call.
     * 
     * @param none
     *
     * @return bool true if user exists and login successful
     */
    public function login()
    {
        // Set the username and pwd to login with
        if(!empty($_SESSION['restlogin']) && $_SESSION['restlogin'] == 'success'){
            return true;
        }
        
        $post_params = array(
            'login' => $this->loginName,
            'password' => $this->password,
        );

        // Execute the login with the credentials as params
        $result = $this->callApi('login', $post_params, true, true);
        $_SESSION['restlogin'] = $result->status;

        return $result->status == 'success';
    }

    /**
     * Use a real login to test login api call.
     * 
     * @param none
     *
     * @return bool true if user exists and login successful
     */
    public function logout()
    {
        // Set the username and pwd to login with
        if(!empty($_SESSION['restlogin'])){
            unset($_SESSION['restlogin']);
        }
        return isset($_SESSION['restlogin']);
    }

    /**
     * Create a list.
     * 
     * @param string $listName        Name of the list
     * @param string $listDescription Description of the list
     *
     * @return int ListId of the list created
     */
    public function listAdd($listName, $listDescription, $category = "")
    {
        // Create minimal params for api call
        $post_params = array(
            'name' => $listName,
            'description' => $listDescription,
            'category' => $category,
            'listorder' => '0',
            'active' => '1',
        );

        // Execute the api call
        $result = $this->callAPI('listAdd', $post_params);

        // get the ID of the list we just created
        $listId = $result->data->id;

        return $listId;
    }

    /**
     * Update a list.
     * 
     * @param int $id List id
     * @param string $listName        Name of the list
     * @param string $listDescription Description of the list
     *
     * @return int ListId of the list created
     */
    public function listUpdate($id, $listName, $listDescription, $category = "")
    {
        // Create minimal params for api call
        $post_params = array(
            'id' => $id,
            'name' => $listName,
            'description' => $listDescription,
            'category' => $category,
            'listorder' => '0',
            'active' => '1',
        );

        // Execute the api call
        $result = $this->callAPI('listUpdate', $post_params);

        // get the ID of the list we just created
        $listId = $result->data->id;

        return $listId;
    }

    /**
     * Delete a List.
     *
     * @param int $id
     * @return mixed System message of action
     */
    public function listDelete($id)
    {

        $post_params = array(
            'id' => $id
        );

        // Execute the api call
        $result = $this->callAPI('listDelete', $post_params);

        return $result;
    }

    /**
     * Get all lists.
     *
     * @return array All lists
     */
    public function listsGet($order = 'listorder', $sort = 'desc', $offset = 0, $limit = 10)
    {
        $post_params = array(
            'order_by' => $order,
            'sort' => $sort,
            'offset' => $offset,
            'limit' => $limit
        );

        // Execute the api call
        $result = $this->callAPI('listsGet', $post_params);

        // Return all list as array
        return $result->data;
    }


    /**
     * Get all lists.
     *
     * @return array All lists
     */
    public function listsGetCategories()
    {
        $post_params = array(
        );

        // Execute the api call
        $result = $this->callAPI('listsGetCategories', $post_params);

        // Return all list as array
        return $result->data;
    }

    /**
     * Get Single list
     *
     * @return array Single list
     */
    public function listGet($id)
    {
        // Create minimal params for api call
        $post_params = array(
            'id' => $id
        );

        // Execute the api call
        $result = $this->callAPI('listGet', $post_params);

        // Return all list as array
        return $result->data;
    }

    /**
     * Count All list
     *
     * @return int list count
     */
    public function listCount($status = false)
    {
        // Create minimal params for api call
//        $post_params = array(
//            'id' => $id
//        );
        // Execute the api call
        $result = $this->callAPI('listCount', []);

        return $result->data->total;
    }

    /**
     * Find a subscriber by email address.
     * 
     * @param string $emailAddress Email address to search
     *
     * @return int $subscriberID if found false if not found
     */
    public function subscriberFindByEmail($emailAddress)
    {
        $params = array(
            'email' => $emailAddress,
        );
        $result = $this->callAPI('subscriberGetByEmail', $params);

        if (!empty($result->data->id)) {
            return $result->data->id;
        } else {
            return false;
        }
    }

    public function subscriberSearch($query, $listID = false, $order = 'id', $sort = 'asc', $offset = 0, $limit = 100)
    {
        $params = array(
            'query' => $query,
            'listID' => $listID,
            'order_by' => $order,
            'sort' => $sort,
            'offset' => $offset,
            'limit' => $limit
        );

        $result = $this->callAPI('subscriberSearch', $params);

        if (!empty($result->data)) {
            return $result->data;
        }
        return false;
    }

    /**
     * Add a subscriber.
     * 
     * This is the main method to use to add a subscriber. It will add the subscriber as 
     * a non-confirmed subscriber in phpList and it will send the Request-for-confirmation
     * email as set up in phpList.
     * 
     * The lists parameter will set the lists the subscriber will be added to. This has
     * to be comma-separated list-IDs, eg "1,2,3,4".
     * 
     * @param string $emailAddress email address of the subscriber to add
     * @param string $lists        comma-separated list of IDs of the lists to add the subscriber to
     *
     * @return int $subscriberId if added, or false if failed
     */
    public function subscribe($emailAddress, $lists)
    {
        // Set the user details as parameters
        $post_params = array(
            'email' => $emailAddress,
            'foreignkey' => '',
            'htmlemail' => 1,
            'subscribepage' => 0,
            'lists' => $lists,
        );

        // Execute the api call
        $result = $this->callAPI('subscribe', $post_params);

        if (!empty($result->data->id)) {
            $subscriberId = $result->data->id;

            return $subscriberId;
        } else {
            return false;
        }
    }

    /**
     * Fetch all subscriber
     *
     * @return List of Subscribers.
     */
    public function subscribersGet($order = 'id', $sort = 'asc', $offset = 0, $limit = 100)
    {
        $post_params = array(
            'order_by' => $order,
            'sort' => $sort,
            'offset' => $offset,
            'limit' => $limit
        );

        // Execute the api call
        $result = $this->callAPI('subscribersGet', $post_params);

        return $result->data;
    }

    /**
     * Fetch subscriber by ID.
     *
     * @param int $subscriberID ID of the subscriber
     *
     * @return the subscriber
     */
    public function subscriberGet($subscriberId)
    {
        $post_params = array(
            'id' => $subscriberId,
        );

        // Execute the api call
        $result = $this->callAPI('subscriberGet', $post_params);
        if (!empty($result->data->id)) {

            return $result->data;
        } else {
            return false;
        }
    }

    /**
     * Get a subscriber by Foreign Key.
     * 
     * Note the difference with subscriberFindByEmail which only returns the SubscriberID
     * Both API calls return the subscriber
     * 
     * @param string $foreignKey Foreign Key to search
     *
     * @return subscriber object if found false if not found
     */
    public function subscriberGetByForeignkey($foreignKey)
    {
        $post_params = array(
            'foreignkey' => $foreignKey,
        );

        $result = $this->callAPI('subscriberGetByForeignkey', $post_params);
        if (!empty($result->data->id)) {
            return $result->data;
        } else {
            return false;
        }
    }

    /**
     * Get the total number of subscribers.
     * 
     * @param none
     *
     * @return int total number of subscribers in the system
     */
    public function subscriberCount()
    {
        $post_params = array(
        );

        $result = $this->callAPI('subscribersCount', $post_params);

        return $result->data->total;
    }

    /**
     * 
     * @param type $email
     * @param type $confirmed
     * @param type $html
     * @param type $foreignKey
     * @param type $subscriberPage
     * @param type $password
     * @param type $disabled
     * @return type
     */
    public function subscriberAdd($email, $confirmed, $html, $foreignKey, $subscriberPage, $password, $disabled)
    {

        $post_params = array(
            'email' => $email,
            'confirmed' => $confirmed,
            'html' => $html,
            'foreignKey' => $foreignKey,
            'subscriberPage' => $subscriberPage,
            'password' => $password,
            'disabled' => $disabled
        );


        $result = $this->callAPI('subscriberAdd', $post_params);

        return $result->data;
    }

    /**
     * 
     * @param array $subscribers
     * @return type
     */
    public function subscriberMultiAdd(array $subscribers)
    {
        $post_params = array(
            'subscribers' => $subscribers
        );

        $result = $this->callAPI('subscriberBulkAdd', $post_params);

        return $result->data;
    }

    public function subscriberImport($emails, $listID = false)
    {
        $post_params = array(
            'emails' => $emails,
            'listID' => $listID ?: ''
        );

        $result = $this->callAPI('subscriberBulkImport', $post_params, false);

        return $result;
    }

    /**
     * 
     * @param type $id
     * @param type $email
     * @param type $confirmed
     * @param type $html
     * @param type $foreignKey
     * @param type $subscriberPage
     * @param type $password
     * @param type $disabled
     * @return type
     */
    public function subscriberUpdate($id, $email, $confirmed, $html, $foreignKey, $subscriberPage, $password, $disabled)
    {

        $post_params = array(
            'id' => $id,
            'email' => $email,
            'confirmed' => $confirmed,
            'html' => $html,
            'foreignKey' => $foreignKey,
            'subscriberPage' => $subscriberPage,
            'password' => $password,
            'disabled' => $disabled
        );


        $result = $this->callAPI('subscriberUpdate', $post_params);

        return $result->data;
    }

    public function subscriberEnable($id)
    {
        $post_params = array(
            'id' => $id,
            'disabled' => 0
        );

        // Execute the api call
        $result = $this->callAPI('subscriberSetStatus', $post_params);

        return $result->data;
    }

    public function subscriberDisable($id)
    {
        $post_params = array(
            'id' => $id,
            'disabled' => 1
        );

        // Execute the api call
        $result = $this->callAPI('subscriberSetStatus', $post_params);

        return $result->data;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function subscriberDelete($id)
    {
        $post_params = array(
            'id' => $id,
        );

        // Execute the api call
        $result = $this->callAPI('subscriberDelete', $post_params);

        return $result->data;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function subscriberBlacklist($id)
    {
        $post_params = array(
            'id' => $id,
        );

        // Execute the api call
        $result = $this->callAPI('subscriberBlacklist', $post_params);

        return $result->data;
    }

    /**
     * Add a subscriber to an existing list.
     * 
     * @param int $listId       ID of the list 
     * @param int $subscriberId ID of the subscriber
     *
     * @return the lists this subscriber is member of
     */
    public function listSubscriberAdd($listId, $subscriberId)
    {
        // Set list and subscriber vars
        $post_params = array(
            'list_id' => $listId,
            'subscriber_id' => $subscriberId,
        );

        $result = $this->callAPI('listSubscriberAdd', $post_params);

        return $result->data;
    }


    /**
     * Add a subscriber to an existing multiple list.
     * 
     * @param array $listIDs       ID of the lists
     * @param int $subscriberId ID of the subscriber
     *
     * @return the lists this subscriber is member of
     */
    public function listSubscriberAddMulti($listIDs, $subscriberId)
    {
        // Set list and subscriber vars
        $post_params = array(
            'list_ids' => $listIDs,
            'subscriber_id' => $subscriberId,
        );

        $result = $this->callAPI('listSubscriberAddMulti', $post_params);

        return $result->data;
    }

    /**
     * Get the lists a subscriber is member of.
     * 
     * @param int $subscriberId ID of the subscriber
     *
     * @return the lists this subcriber is member of
     */
    public function listsSubscriber($subscriberId)
    {
        $post_params = array(
            'subscriber_id' => $subscriberId,
        );

        $result = $this->callAPI('listsSubscriber', $post_params);

        return $result->data;
    }

    /**
     * Remove a Subscriber from a list.
     *
     * @param int $listId       ID of the list to remove
     * @param int $subscriberId ID of the subscriber
     *
     * @return the lists this subcriber is member of
     */
    public function listSubscriberDelete($listId, $subscriberId)
    {
        // Set list and subscriber vars
        $post_params = array(
            'list_id' => $listId,
            'subscriber_id' => $subscriberId,
        );

        $result = $this->callAPI('listSubscriberDelete', $post_params);

        return $result->data;
    }

    /**
     * Remove a Subscriber from a list.
     *
     * @param int $listId       ID of the list to remove
     * @param int $subscriberId ID of the subscriber
     *
     * @return the lists this subcriber is member of
     */
    public function listSubscriberDeleteMulti($listIDs, $subscriberId)
    {
        // Set list and subscriber vars
        $post_params = array(
            'list_ids' => $listIDs,
            'subscriber_id' => $subscriberId,
        );

        $result = $this->callAPI('listSubscriberDeleteMulti', $post_params);

        return $result->data;
    }

    /**
     * Get all subscribers from a list
     * 
     * <p><strong>Parameters:</strong><br/>
     * [*list_id] {integer} the List-ID.
     * <p><strong>Returns:</strong><br/>
     * Array of subscribers assigned to the list.
     * </p>
     */
    public function listSubscribers($list_id, $order = 'id', $sort = 'asc', $offset = 0, $limit = 100)
    {
        $post_params = array(
            'list_id' => $list_id,
            'order_by' => $order,
            'sort' => $sort,
            'offset' => $offset,
            'limit' => $limit
        );

        $result = $this->callAPI('listSubscribers', $post_params);

        return $result->data;
    }

    /**
     * Get num of subscribers from a list
     *
     * <p><strong>Parameters:</strong><br/>
     * [*list_id] {integer} the List-ID.
     * <p><strong>Returns:</strong><br/>
     * List_id and count of subscriber.
     * </p>
     */
    public function listSubscribersCount($list_id)
    {
        $post_params = array(
            'list_id' => $list_id
        );

        $result = $this->callAPI('listSubscribersCount', $post_params);

        return $result->data->count;
    }

    /**
     * Sync multiple list of subscriber
     *
     * <p><strong>Parameters:</strong><br/>
     * [*list_id] {integer} the List-ID.
     * <p><strong>Returns:</strong><br/>
     * List_id and count of subscriber.
     * </p>
     */
    public function listSubscriberSync($subscriberID, $list_ids) // @ TODO, Work on phplist API Plugin
    {
        $post_params = array(
            'subscriber_id' => $subscriberID,
            'list_ids' => $list_ids
        );

        $result = $this->callAPI('listSubscriberSync', $post_params);

        return $result->data->count;
    }

    /**
     * Assigns a list to a campaign
     * 
     * @param int $listId
     * @param int $campaignId
     * 
     * @return mixed
     */
    public function listCampaignAdd($listId, $campaignId)
    {
        // Set list and subscriber vars
        $post_params = array(
            'list_id' => $listId,
            'campaign_id' => $campaignId,
        );

        $result = $this->callAPI('listCampaignAdd', $post_params);

        return $result->data;
    }

    /**
     * Unassigns a list from a campaign.
     *
     * @param int $listId       ID of the list to remove
     * @param int $campaignId ID of the campaign
     *
     * @return System message of action.
     */
    public function listCampaignDelete($listId, $campaignId)
    {
        $post_params = array(
            'list_id' => $listId,
            'campaign_id' => $campaignId,
        );

        $result = $this->callAPI('listCampaignDelete', $post_params);

        return $result->data;
    }

    public function listsByCampaign(int $campaignID)
    {

        $post_params = array(
            'campaign_id' => $campaignID,
        );

        $result = $this->callAPI('listsByCampaign', $post_params);

        return $result->data;
    }

    /**
     * Add a new campaign.
     * 
     * @param string $subject
     * @param string $fromfield
     * @param string $replyto
     * @param string $message
     * @param string $textmessage
     * @param string $footer
     * @param string $status
     * @param string $sendformat
     * @param string $template
     * @param string $embargo
     * @param string $rsstemplate
     * @param string $owner
     * @param string $htmlformatted
     * 
     * @return The message added.
     */
    public function campaignAdd($subject, $fromfield, $replyto, $message, $textmessage, $footer, $status, $sendformat, $template, $embargo, $rsstemplate, $owner, $htmlformatted)
    {
        $post_params = array(
            'subject' => $subject,
            'fromfield' => $fromfield,
            'replyto' => $replyto,
            'message' => $message,
            'textmessage' => $textmessage,
            'footer' => $footer,
            'status' => $status,
            'sendformat' => $sendformat,
            'template' => $template,
            'embargo' => $embargo,
            'rsstemplate' => $rsstemplate,
            'owner' => $owner,
            'htmlformatted' => $htmlformatted
        );

        $result = $this->callAPI('campaignAdd', $post_params);

        return $result->data;
    }

    /**
     * Update existing campaign.
     * 
     * @param int $id
     * @param string $subject
     * @param string $fromfield
     * @param string $replyto
     * @param string $message
     * @param string $textmessage
     * @param string $footer
     * @param string $status
     * @param string $sendformat
     * @param string $template
     * @param string $embargo
     * @param string $rsstemplate
     * @param string $owner
     * @param string $htmlformatted
     * 
     * @return The message added.
     */
    public function campaignUpdate($id, $subject, $fromfield, $replyto, $message, $textmessage, $footer, $status, $sendformat, $template, $embargo, $rsstemplate, $owner, $htmlformatted)
    {
        $post_params = array(
            'id' => $id,
            'subject' => $subject,
            'fromfield' => $fromfield,
            'replyto' => $replyto,
            'message' => $message,
            'textmessage' => $textmessage,
            'footer' => $footer,
            'status' => $status,
            'sendformat' => $sendformat,
            'template' => $template,
            'embargo' => $embargo,
            'rsstemplate' => $rsstemplate,
            'owner' => $owner,
            'htmlformatted' => $htmlformatted
        );

        $result = $this->callAPI('campaignUpdate', $post_params);

        return $result->data;
    }
    public function campaignDelete(int $id){
        if(empty($id)){
            return false;
        }
        $post_params = array(
            'id' => $id
        );
        $result = $this->callAPI('campaignDelete', $post_params);
        return $result->status === 'success' ?? false;
    }
    

    public function campaignUpdateStatus(int $campaignID, $status)
    {

        $post_params = array(
            'id' => $campaignID,
            'status' => $status
        );

        $result = $this->callAPI('campaignUpdateStatus', $post_params);

        return $result->data;
    }

    /**
     * Get all the Campaigns in the system.
     *
     * @return List of Campaigns.
     */
    public function campaignsGet($order = 'id', $sort = 'asc', $offset = 0, $limit = 10, $status = false)
    {
        $post_params = array(
            'order_by' => $order,
            'sort' => $sort,
            'offset' => $offset,
            'limit' => $limit
        );
        if (!empty($status)) {
            $post_params['status'] = $status;
        }
        // Execute the api call
        $result = $this->callAPI('campaignsGet', $post_params);

        return $result->data;
    }

    public function campaignSearch($query)
    {
        $post_params = array(
            'query' => $query
        );

        // Execute the api call
        $result = $this->callAPI('campaignSearch', $post_params);

        return $result->data;
    }

    public function campaignsAnalytics($order = 'id', $sort = 'asc', $offset = 0, $limit = 10, $status = false)
    {
        $post_params = array(
            'order_by' => $order,
            'sort' => $sort,
            'offset' => $offset,
            'limit' => $limit
        );
        if (!empty($status)) {
            $post_params['status'] = $status;
        }
        // Execute the api call
        $result = $this->callAPI('campaignsAnalyticGet', $post_params);

        return $result->data;
    }

    public function campaignsGetByDateRange($range, $order = 'id', $sort = 'asc', $offset = 0, $limit = 10, $status = false)
    {
        $post_params = array(
            'date_range' => $range,
            'order_by' => $order,
            'sort' => $sort,
            'offset' => $offset,
            'limit' => $limit
        );
        if (!empty($status)) {
            $post_params['status'] = $status;
        }
        // Execute the api call
        // $result = $this->callAPI('campaignsAnalyticGet', $post_params);
        $result = $this->callAPI('campaignsGet', $post_params);

        return $result->data;
    }

    /**
     * Fetch Campaign by ID.
     *
     * @param int $campaignId
     *
     * @return the campaign
     */
    public function campaignGet($campaignId, $exclude_details = false)
    {
        $post_params = array(
            'id' => $campaignId,
            'exclude_details' => $exclude_details
        );

        // Execute the api call
        $result = $this->callAPI('campaignGet', $post_params);

        if (!empty($result->data->id)) {

            return $result->data;
        } else {
            return false;
        }
    }

    /**
     * Get the total number of campaigns.
     * 
     * @param none
     *
     * @return int total number of campaigns in the system
     */
    public function campaignsCount($status = false)
    {
        $post_params = array(
            'status' => $status,
        );

        $result = $this->callAPI('campaignsCount', $post_params);

        return $result->data->total;
    }

    public function campaignStopAfter($campaignID, string $time)
    {
        $post_params = array(
            'campaignID' => $campaignID,
            'time' => $time,
        );

        $result = $this->callAPI('campaignStopAfter', $post_params, false);

        return $result;
    }

    public function analytics($start, $end, $items = false, $options = false)
    {
        $post_params = array(
            'date_range_start' => $start,
            'date_range_end' => $end,
            'items' => $items,
            'options' => $options
        );

        $result = $this->callAPI('analytics', $post_params, true);

        return $result;
    }

    /**
     * 
     * @param date $start
     * @param date $end
     * @param string $rangeMode DATE or WEEK or MONTH
     * @param int $format 1 OR 2
     * @return type
     */
    public function analyticsByDateRange($start, $end, $rangeMode = 'DATE', $format = 1)
    {
        $post_params = ['date_range' => $start . '|' . $end, 'range_mode' => $rangeMode, 'format_mode' => $format];

        $result = $this->callAPI('countByDateRange', $post_params, true);

        return $result;
    }

    public function analyticsByCampaignDateRange(int $campaignID, string $start, string $end, string $rangeMode = 'DATE', $format = 1)
    {
        $post_params = ['campaign_id' => $campaignID, 'date_range' => $start . '|' . $end, 'range_mode' => $rangeMode, 'format_mode' => $format];

        $result = $this->callAPI('countByDateRangeAndCampaign', $post_params, true);

        return $result;
    }

    public function analyticsByListDateRange(int $listID, string $start, string $end, string $rangeMode = 'DATE', $format = 1)
    {
        $post_params = ['list_id' => $listID, 'date_range' => $start . '|' . $end, 'range_mode' => $rangeMode, 'format_mode' => $format];

        $result = $this->callAPI('countByDateRangeAndList', $post_params, true);

        return $result;
    }

    public function campaignInProcessData($id = false)
    {
        $result = $this->callAPI('campaignInProcessData', $id ? ['id' => $id] : [], true);

        return $result->data ?? false;
    }

    public function campaignTotalQueue($campaignID = false)
    {
        $result = $this->callAPI('countTotalQueue', $campaignID ? ['id' => $campaignID] : [], true);

        return $result->data ?? false;
    }

    public function getConfig(string $item)
    {
        $post_params = ['item' => $item];

        $result = $this->callAPI('getConfig', $post_params, true);

        return $result->data ?? false;
    }

    public function setConfig(string $item, $value)
    {
        $post_params = ['item' => $item, 'value' => $value];

        $result = $this->callAPI('setConfig', $post_params, true);

        return $result->data ?? false;
    }

    public function getMessageData(string $name, int $id)
    {
        $post_params = ['name' => $name, 'id' => $id];

        $result = $this->callAPI('getMessageData', $post_params, true);

        return $result->data ?? false;
    }

    public function setMessageData(string $name, int $id, $data)
    {
        $post_params = ['name' => $name, 'id' => $id, 'data' => $data];

        $result = $this->callAPI('setMessageData', $post_params, true);

        return $result->data ?? false;
    }

    public function setNotificationReceiver(int $id, string $email)
    {
        $this->setMessageData('notify_start', $id, $email);
        $this->setMessageData('notify_end', $id, $email);

        return true;
    }
}
