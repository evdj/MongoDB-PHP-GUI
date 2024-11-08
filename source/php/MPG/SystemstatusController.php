<?php

namespace MPG;

class SystemstatusController extends Controller {

    public function manage() : ViewResponse {

        AuthController::ensureUserIsLogged();
        
        return new ViewResponse(200, 'systemStatus', [
            'systemStatus' => DatabasesController::getSystemStatus()
        ]);

    }
}
