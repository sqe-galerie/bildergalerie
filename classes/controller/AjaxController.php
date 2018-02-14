<?php
 
  

/**
 *
 * This controller handles all asynchronous
 * requests.
 * All actions produce responses in json format.
 *
 * User: Marc
 * Date: 19.02.16
 * Time: 07:41
 *
 * @JsonResponse
 */
class AjaxController extends BildergalerieController
{

    /**
     * @var Mandant
     */
    private $mandant;

    /**
     * @var PicRatingDAO
     */
    private $ratingDAO;

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
        $this->ratingDAO = new PicRatingDAO($this->baseFactory->getDbConnection(), $this->mandant);
    }


    /**
     * Default action which will be executed
     * if no specific action is given.
     *
     * Each action returns the {@link View}
     * which will be displayed.
     *
     * @return View
     * @throws UnsupportedAjaxCall
     */
    public function indexAction()
    {
        throw new UnsupportedAjaxCall();
    }

    /**
     * @return string
     * @throws Exception
     * @throws FileAlreadyExists
     * @throws IllegalArgumentException
     * @AuthRequired
     */
    public function uploadAction()
    {
        $resultArray = array(
            "status"    => "ERR",
            "errMsg"   => "Das Bild konnte nicht gespeichert werden."
        );

        if (!array_key_exists("uploadFile", $this->getRequest()->getFiles())) {
            throw new IllegalArgumentException("Uploaded file not given.");
        }

        $file = $this->getRequest()->getFiles()["uploadFile"];

        $dirName = "uploads/" . $this->mandant->getMandantId();
        if (!is_dir($dirName)) {
            mkdir($dirName);
        }

        $picUploader = new PictureUploader($file, $dirName);
        if (!$picUploader->uploadFile()) {
            // upload failed so we return the default error message
            return json_encode($resultArray);
        }

        // picture upload was successful, now we save the path in our database
        try {
            $picPathDAO = new PicturePathDAO($this->baseFactory->getDbConnection(), $this->mandant);

            $picturePath = new PicturePath($this->mandant, /* id will be created */
                null, $picUploader->getUploadedFilePath(),
                $picUploader->getThumbFilePath(), $this->baseFactory->getAuthenticator()->getLoggedInUser());

            $picPathId = $picPathDAO->createPicturePath($picturePath);
        } catch (Exception $e) {
            // if anything goes wrong, we must delete the uploaded file
            $picUploader->deleteUploadedFiles();
            throw $e;
        }


        $resultArray["status"] = "OK";
        $resultArray["picPathId"] = $picPathId;
        $resultArray["filePath"] = $picUploader->getUploadedFilePath();
        $resultArray["fileName"] = $file["name"];
        $resultArray["thumbPath"] = $picUploader->getThumbFilePath();
        return json_encode($resultArray);
    }

    /**
     * Gets all Tags. Used for the tags
     * typeahead in the create pictures form
     * for example.
     *
     * @return string
     */
    public function getTagsAction()
    {
        $tagDAO = new TagDAO(
            $this->baseFactory->getDbConnection(), $this->mandant);

        $tags = $tagDAO->queryForAll();

        $tagsArr = array();

        foreach ($tags as $tag) {
            $tagsArr[] = $tag->getTagName();
        }

        return json_encode($tagsArr);
    }

    /**
     * Adds a new category with details.
     *
     * @return string
     * @AuthRequired
     */
    public function addCategoryAction()
    {
        $get = $this->getRequest()->getGetParam(); 

        // create request object
        $request = new \App\Exhibition\CreateOrUpdate\Request(); 
        $request->id = self::getValueOrNull("editId", $get);  
        if (array_key_exists("name", $get)) {
            $request->name = $get["name"];
        } else {
            throw new InvalidArgumentException("Parameter name missing.");
        } 
        if (array_key_exists("description", $get)) {
            $request->description = $get["description"];
        } else {
            throw new InvalidArgumentException("Parameter description missing.");
        }
         
        // do some work
        $boundary = $this->application->getExhibitionBoundary();
        $response = $boundary->createOrUpate($request); 

        // result to json
        $resultArray = array(
            "status"    => "OK"
        );
        $resultArray["category_id"] = $response->id;
        $resultArray["category_name"] = $request->name;
        $resultArray["category_description"] = $request->description;

        return json_encode($resultArray); 
    }

    /**
     * Assign a picture into categories.
     *
     * @return string
     * @AuthRequired
     */
    public function categorizePicAction()
    {
        $resultArray = array(
            "status"    => "OK"
        );

        $post = $this->getRequest()->getPostParam();

        // TODO: validate input
        $picId = self::getValueOrNull("picId", $post);
        $categories = self::getValueOrNull("categories", $post);

        if (null == $picId) {
            throw new InvalidArgumentException("Parameter picId missing.");
        }

        if (null == $categories) {
            throw new InvalidArgumentException("Parameter categories missing.");
        }

        if (count($categories) == 0) {
            throw new InvalidArgumentException("There must be at least one category given.");
        }

        $picCatMapDAP = new PicCatMapDAO($this->baseFactory->getDbConnection(), $this->mandant);
        foreach ($categories as $catId) {
            $picCatMapDAP->createEntry($picId, new Category($this->mandant, $catId));
        }

        $derden = (count($categories) == 1) ? "der Ausstellung" : "den Ausstellungen";
        $this->getAlertManager()->setSuccessMessage("<strong>OK: </strong> Das Gemälde wurde $derden zugeordnet.");

        return json_encode($resultArray);
    }

    /**
     * Performs the rate action.
     *
     * @return string
     * @throws IllegalStateException
     */
    public function rateAction()
    {
        $resultArray = array(
            "status"    => "OK"
        );

        $get = $this->getRequest()->getGetParam();

        if (!array_key_exists("picId", $get)) {
            throw new InvalidArgumentException("Parameter pidId missing.");
        }

        if (!array_key_exists("value", $get)) {
            throw new InvalidArgumentException("Parameter value missing.");
        }

        $picId = $get["picId"];
        $ratingeValue = $get["value"];

        if ($ratingeValue < 1 || $ratingeValue > 5) {
            throw new InvalidArgumentException("Value must be between 1 and 5");
        }

        $visitorRatingId = RatingManager::getVisitorRatingId();

        $result = true;
        $update = false;
        $ratingId = $this->ratingDAO->getRatingIdForVisitor($visitorRatingId, $picId);
        if (null != $ratingId) {
            // update rating value
            $this->ratingDAO->updateVotingEntry($ratingeValue, $ratingId);
            $update = true;

        } else {
            // create a new rating value
            $result = $this->ratingDAO->createVotingEntry($picId, $ratingeValue, $visitorRatingId);
        }

        if ($result == false) {
            throw new IllegalStateException("Could not save rating");
        }

        // fetch the current overall rating value
        $overallRating = $this->ratingDAO->getOverallRatingForPic($picId);

        $resultArray["overall_rating"] = $overallRating;
        $resultArray["value"] = $ratingeValue;
        $resultArray["update"] = $update;

        return json_encode($resultArray);
    }

}