<?php

declare(strict_types=1);

const AVAILABLE_ROUTES = [
     'error' => 'ErrorController',
     'about' => 'AboutController',
     'login' => 'LoginController',
     'logout' => 'LogoutController',
     'board' => 'BoardController',
     'projet' => 'ProjetController',
     'change' => 'ChangeController',
     'experience' => 'ExperienceController',
     'createExperience' => 'CreateExperienceController',
     'changeExperience' => 'ChangeExperienceController',
     'create' => 'CreateController',
     'changeCompetence' => 'ChangeCompetenceController',
];



const DEFAULT_ROUTE = 'about';