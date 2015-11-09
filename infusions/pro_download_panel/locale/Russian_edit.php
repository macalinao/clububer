<?php
/***************************************************************************
 *   Professional Download System                                          *
 *                                                                         *
 *   Copyright (C) pirdani                                                 *
 *   pirdani@hotmail.de                                                    *
 *   http://pirdani.de/                                                    *
 *                                                                         *
 *   Copyright (C) 2005 EdEdster (Stefan Noss)                             *
 *   http://edsterathome.de/                                               *
 *                                                                         *
 *   Copyright (C) 2006-2007 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *   http://wibix.de/                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *  --------------------------------------------------------------------   *
 *         Перевод на Русский язык: Skorpion - http://cst-m.ru             *
 *  --------------------------------------------------------------------   *
 ***************************************************************************/
$locale['PDP900'] = array(
	0		=> "OK",//FIXME
	PDP_EIMG	=> "Ошибка с картинкой",//FIXME
	PDP_EACCESS	=> "Доступ закрыт!",
	PDP_EURL	=> ". ".$locale['PDP220'],
	PDP_EFILE	=> "Файл не найден.",
	PDP_EUPDIR	=> "Вы не можете загрузить файл в папку %s , потому что нехватает прав. Проверьте права на запись в папке.",
	PDP_ECATS	=> "Вы не можете добавить новые загрузки, потому что нет доступных категорий.",
	PDP_EEXT	=> "Не разрешенный тип файла",
	PDP_ESIZE	=> "Файл очень большой. Разбейте его на части.",
	PDP_EIMGVERIFY	=> "Недействительное содержание изображения (verify_image())!",
	PDP_EUPDATED	=> "Не могу изменить статус, потому что загрузка была изменена кемто другим прямо сейчас.",
	//
	PDP_EUPLOAD	=> "Произошла ошибка во время загрузки файла на сервер.",
	PDP_EUPLOAD1 => "Файл слишком большой (> upload_max_filesize in php.ini)",
	PDP_EUPLOAD2 => "Файл слишком большой (> MAX_FILE_SIZE)",
	PDP_EUPLOAD3 => "Не могу загрузить файл в данное место",
	PDP_EUPLOAD4 => "Файл не загружен.",
	PDP_EUPLOAD5 => "",
	PDP_EUPLOAD6 => "Временная директория не доступна.",
	PDP_EUPLOAD7 => "Не сохранено.",
);
$locale['PDP902']['subject'] = array(
	PDP_PM_COMMENT	=> "PDP: Новый коментарий",
	PDP_PM_NEW	=> "PDP: Новая загрузка",
	PDP_PM_BROKEN	=> "PDP: Загрузка битая",
	PDP_PM_CHANGES	=> "PDP: Загрузка была обновлена",
	PDP_PM_CHECK	=> "PDP: Загрузка должна быть проверена",
	PDP_PM_ACCEPTED	=> "PDP: Ваша загрузка активирована и доступна для скачивания.",
);
$locale['PDP902']['body'] = array(
	PDP_PM_COMMENT	=> "Новый коментарий был добавлен.",
	PDP_PM_NEW	=> "Новая загрузка была добавлена.",
	PDP_PM_BROKEN	=> "Загрузка была помечена как БИТАЯ.",
	PDP_PM_CHANGES	=> "Загрузка была обновлена.",
	PDP_PM_CHECK	=> "Загрузка была обновлена и теперь она должна быть быть проверена модератором.",
	PDP_PM_ACCEPTED	=> "Модератор опубликовал ваш файл для общего пользования.",
);

?>
