<?php

namespace App;

enum TaskStatus: string
{
    case A_FAIRE = 'a_faire';

    case EN_COURS = 'en_cours';
    case EN_REVEU = 'en_revue';
    case APPROUVE = 'approuve';
    case REJETE = 'rejete';
}
