<?php

/**
 * Controller to hanlde authentication
 * requests like login or logout.
 *
 * User: Felix
 * Date: 13.02.2016
 * Time: 23:57
 */
class AuthController extends BildergalerieController
{

    /**
     * Default action which will be executed
     * if no specific action is given.
     *
     * Each action returns the {@link View}
     * which will be displayed.
     *
     * @return View
     */
    public function indexAction()
    {
        return $this->loginAction();
    }

    /**
     * Displays a login form and a evaluates the
     * result of the form.
     *
     * @return BootstrapView
     * @throws ReRouteRequestException
     */
    public function loginAction()
    {
        $failure = false;
        if (array_key_exists("submit_login", $this->getRequest()->getPostParam())) { // login form submitted
            $username = $this->getRequest()->getPostParam()["inputUser"];
            $pass = $this->getRequest()->getPostParam()["inputPassword"];
            $authenticated = $this->baseFactory->getAuthenticator()->authenticate($username, $pass);
            if ($authenticated) {
                $this->getAlertManager()->setSuccessMessage("<strong>Super!</strong> Willkommen zurück!");
                $this->getRouter()->rewindAndRestartRouting();
            } else {
                $failure = true;
            }
        }

        $view = BootstrapView::getContentFrameView("Login", new LoginView($failure));
        return $view;
    }

    /**
     * Performs the logout action.
     */
    public function logoutAction()
    {
        $this->baseFactory->getAuthenticator()->logout();
        $this->getAlertManager()->setSuccessMessage("Auf Wiedersehen!");
        $this->getRouter()->reLocateTo();
    }
}