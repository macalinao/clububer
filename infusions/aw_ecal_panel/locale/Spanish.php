<?php
/***************************************************************************
 *   awEventCalendar                                                       *
 *                                                                         *
 *   Copyright (C) 2006-2008 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
$locale['EC000'] = "awEventCal";
$locale['EC001'] = "Eventos";
$locale['EC002'] = "Noticia";
$locale['EC003'] = "Aviso";
$locale['awec_no_events']	= "No hay eventos.";//FIXME
$locale['EC005'] = "Info...";
$locale['EC006']	= 'Seguro que quieres borrar?';
$locale['EC007'] = "Mis";
$locale['EC008'] = "Inscripciones";
$locale['EC009'] = "Mes";
$locale['EC010'] = "A�o";
$locale['EC011'] = "Buscar";
//
$locale['EC013'] = "Nuevos Eventos";
$locale['awec_user_birthday']	= 'Cumplea�os %s';
$locale['awec_user']		= 'Cumplea�os';
$locale['awec_link']		= 'Link al evento';


// edit_event.php
$locale['EC100'] = "Nuevo Evento";
$locale['EC101'] = "Editar Evento";
$locale['EC102'] = "Ver Evento";
$locale['EC103'] = "T�tulo";
$locale['EC104'] = "Descripci�n";
$locale['awec_date']	= 'Fecha';
$locale['awec_beginn']	= 'Desde';
$locale['awec_end']	= 'Hasta';
$locale['EC106'] = "Opciones";
$locale['EC107'] = "Repetir";
$locale['EC108'] = "Evento privado";
$locale['EC109'] = "Permitir inscribirse al evento";
$locale['EC110'] = "Inscripciones m�ximas";
$locale['EC110_1'] = "(0 sin l�mite)";
$locale['EC111'] = "Guardar";
$locale['EC112'] = "Desactivar Smileys";
$locale['EC113'] = array(
	0		=> 'Evento actualizado correctamente!',
	EC_ELOGIN	=> "No registrations for private events allowed.",
	EC_EDB		=> "Error al actualizar la Base de Datos.",
	EC_ESTATUS	=> "Este evento debe ser validado por un admin.",
	EC_EACCESS	=> "No access limits for private events allowed.",
	EC_EIMG		=> "Imagen inv�lida.",
	EC_EDATE	=> "Fecha inv�lida.",
);
$locale['EC114'] = "No es posible inscribirse a este evento.";
$locale['EC115'] = array(
	1 => "M�ximo n�mero de inscripciones alcanzado.",
	2 => "Valor de estado inv�lido.",
	3 => "No es posible actualizar el estado de la inscripci�n.",
	4 => "Ning�n destinatario especificado.",
);
$locale['EC116'] = "Inscripciones";
//$locale['EC117'] = "";
$locale['awec_mandatory']	= '* campos obligatorios';
$locale['awec_break']		= '** Despu�s del texto %s, no aparecer� en el panel lateral. Se evita sobrecargar el panel.';
$locale['EC119'] = "Por favor, rellena todos los campos obligatorios (*)!";
$locale['awec_date_fmt']	= 'D�a.Mes.A�o';
$locale['awec_time_fmt']	= 'Horas:Minutos';
$locale['EC121'] = "Imagen";
$locale['EC122'] = "Misc";
$locale['EC123'] = "Fin";
$locale['EC124'] = "Permitir inscripciones exclusivamente en estas fechas.";
$locale['EC125'] = array(
	0 => "---",
	1 => "Anual",
	2 => "Mensual",
	4 => "Semanal",
);


// aw_ecal_panel.php
$locale['EC200'] = "Enviar Evento";
$locale['EC201'] = "Hoy";
$locale['EC202'] = "Ma�ana";
$locale['EC203'] = "Nuevos eventos necesitan ser validados!";
$locale['EC204'] = "Mis Eventos";
$locale['EC205'] = "Cumplea�o(s)";
$locale['EC206'] = "Mis Inscripciones";
$locale['EC207'] = "[m�s]";
$locale['EC208'] = "Pr�ximos %s d�as";
$locale['EC209'] = array(
	'today'		=> 'Hoy',
	'tomorrow'	=> 'Ma�ana',
	'others'	=> 'Pr�ximamente...',
);


// view_event.php
$locale['EC300'] = "Evento";
$locale['EC301'] = $locale['EC113'][3];
$locale['EC302'] = "Precauci�n! Usuario no encontrado en la base de datos.";
$locale['EC303'] = "Desconocido";
$locale['EC304'] = "Editar";
$locale['EC305'] = "Borrar";
$locale['EC306'] = "Publicar";
$locale['EC307'] = "Desactivar";
//EC308
$locale['EC309'] = array(
	0 => "No inscrito a este evento.",
	1 => "Inscrito",
	2 => "Pre-Inscrito",
	3 => "Cancelado",
	4 => "Invitado",
);
$locale['EC310'] = array(
	1 => "Inscrito",
	2 => "Pre-Inscrito",
	3 => "Cancelar",
);
$locale['EC311'] = "Estado actual:";
$locale['EC312'] = "Comentario";
$locale['EC313'] = "Enviar E-Mail";
$locale['EC314'] = "Enviar un e-mail a cada uno";
$locale['EC315'] = "Enviar un e-mail a todos";
$locale['EC316'] = "Enviar";
$locale['EC317'] = "Alg�n campo no es correcto.";
$locale['EC318'] = "No hay receptores especificados. Por favor compru�balo!";
$locale['EC319'] = "Todos";
$locale['EC320'] = "Los E-mail(s) se han enviado!";
$locale['EC321'] = "Formato-HTML";
$locale['EC322'] = "Invitar";
$locale['EC323'] = "Usa CTRL/SHIFT para seleccionar varios";
$locale['EC324'] = 'Enviar PM';
$locale['awec_invite_title']	= 'Invitaci�n';
$locale['awec_invite_body']	= 'Has sido invitado a un evento de la agenda Emen Corps.';


// calendar.php
$locale['awec_calendar'] = "Calendario";
$locale['EC401'] = "Cumplea�os este mes";
$locale['EC402'] = "Ver";
$locale['awec_month_view'] = array(
	'calendar'	=> 'Calendario',
	'list'		=> 'Lista',
);


// browse.php
$locale['EC450'] = "A�o";
$locale['EC451'] = "Ver";


// new_events.php
$locale['EC500'] = "Nuevos Eventos";
$locale['EC501'] = "No hay Eventos para validar.";
$locale['EC502'] = array(
	1 => "Could not publish event, since it was altered meanwhile. Please check it again!",
);


// search.php
$locale['EC550'] = "Buscar";
$locale['EC551'] = array(
	"AND"	=> "Y",
	"OR"	=> "O",
	"-"	=> "No",
);
$locale['EC552'] = "Eventos encontrados.";
$locale['EC553'] = "Opciones";
$locale['EC554'] = "Tu b�squeda debe tener al menos 3 caracteres.";


// my_events.php
$locale['EC600'] = "Mis Eventos";
$locale['EC601'] = "No hay eventos enviados a�n.";
$locale['EC602'] = array(
	0	=> "Otros",
	1	=> "Privado",
);


// admin.php
$locale['EC700'] = "Configuraci�n";
$locale['EC701'] = "Grupo-Admin";
$locale['EC702'] = "Validar nuevos eventos por el Grupo-Admin";
$locale['EC703'] = "Permitir enviar eventos";
$locale['EC704'] = "Mostrar <i>HOY</i> en el panel lateral.";
$locale['EC705'] = "Mostrar cumplea�os en el panel lateral.";
$locale['EC706'] = "Mostrar cumplea�os a";
$locale['EC711'] = "Formato Fecha/Hora";//FIXME
$locale['EC712'] = "Cumplea�os";
$locale['EC713'] = "Est�ndar";
$locale['EC714'] = "S�lo usado cuando no est� especificado en el theme.";
$locale['EC715'] = "Borrar Eventos";
$locale['EC716'] = 'Borrar los eventos m�s viejos que los d�as indicados.';
$locale['EC716_']	= 'Eventos repetitivos no ser�n borrados!';
$locale['EC717'] = array(
	0	=> "Guardado",
	1	=> "Eventos viejos borrados!",
);
$locale['EC718'] = "eventos ser�n borrados";
$locale['EC719'] = "%d - d�a del mes, n�mero (00..31)
%m - mes, n�mero (00..12)
%Y - a�o, n�mero 4 d�gitos
%H - horas
%i - minutos
M�s info respecto al formato de fecha DATE_FORMAT: <a href='http://dev.mysql.com/doc/refman/4.1/en/date-and-time-functions.html#id3022503' target='_blank'>Aqu�</a>";
$locale['EC720'] = "Previsualizar";
$locale['EC721'] = "D�as";
$locale['EC722'] = "Pr�ximos d�as en el panel lateral";
$locale['EC723'] = "Semanas empiezan en domingo";
$locale['EC724'] = "Panel Lateral";
$locale['EC725'] = "Soporte s�lo:";
$locale['EC726'] = 'Hora';
$locale['awec_default_month_view']	= 'Mostrar mes como';
$locale['awec_custom_css']		= 'Usar CSS personalizado (ver README)';
$locale['awec_alt_side_calendar']	= 'Usar Calendario-Lateral alternativo (sin CSS)';

// admin/misc.php
$locale['EC750']		= 'Misc';
$locale['awec_old_events']	= 'Eventos Pasados';

// include/db_update.php
$locale['EC800'] = "Actualizaci�n disponible";
$locale['EC801'] = "Las siguientes sentencias SQL ser�n ejecutadas";
$locale['EC802'] = "Comienzo Actualizaci�n...";
//
$locale['EC804'] = "Hecho!";
$locale['EC805'] = "OK";
$locale['EC806'] = "Error";


// others
$locale['EC900'] = array(
	0 => 'Diciembre',
	1 => 'Enero',
	2 => 'Febrero',
	3 => 'Marzo',
	4 => 'Abril',
	5 => 'Mayo',
	6 => 'Junio',
	7 => 'Julio',
	8 => 'Agosto',
	9 => 'Septiembre',
	10 => 'Octubre',
	11 => 'Noviembre',
	12 => 'Diciembre',
);
$locale['EC901'] = array(
	0 => 'Do',
	1 => 'Lu',
	2 => 'Ma',
	3 => 'Mi',
	4 => 'Ju',
	5 => 'Vi',
	6 => 'Sa',
	7 => 'Do',
);
?>
