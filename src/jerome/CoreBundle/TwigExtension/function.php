<?php
$note_function = new Twig_SimpleFunction('getNote', function ($note) {
    $note_increment = 0;
    $note_html = '';
    while ($note_increment != 5) {
        if ($note_increment >= $note) {
            $note_html .= '<i class="fa fa-star-o stars" aria-hidden="true"></i>';
        } else {
            $delta = $note_increment;
            $delta++;
            if ($delta > $note) {
                if (is_float($delta - $note)) {
                    $note_html .= '<i class="fa fa-star-half-o stars" aria-hidden="true"></i>';
                }
            } else {
                $note_html .= '<i class="fa fa-star stars" aria-hidden="true"></i>';
            }
        }
        $note_increment++;
    }
    return $note_html;
});
$this->twig->addFunction($note_function);

$get_moyenne = new Twig_SimpleFunction('getMoyenne', function (array $notes) {
    if (!empty($notes)) {
        $note_tmp = 0;
        foreach ($notes as $note) {
            $note_tmp += $note['note'];
        };
        return $note_tmp / count($notes);
    }
    return 0;
});
$this->twig->addFunction($get_moyenne);

$get_class_error = new Twig_SimpleFunction('getClassError', function ($champ) {
    \kayzore\bundle\Utils\FlashMessage::displayFormClassError($champ);
});
$this->twig->addFunction($get_class_error);

$get_label_error = new Twig_SimpleFunction('getLabelError', function ($champ) {
    \kayzore\bundle\Utils\FlashMessage::displayFormMessageError($champ);
});
$this->twig->addFunction($get_label_error);

$get_champ_value = new Twig_SimpleFunction('getChampValue', function ($champ, $select = null, $optionSelect = null) {
    \kayzore\bundle\Utils\FlashMessage::displayChampValue($champ, $select, $optionSelect);
});
$this->twig->addFunction($get_champ_value);

