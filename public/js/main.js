(function ($) {

    "use strict";

    // init du calendrier à la date courante
    $(document).ready(function () {
        var date = new Date();
        var today = date.getDate();

        // init des clicks handlers pour gestion des events
        $(".right-button").click({ date: date }, next_year);
        $(".left-button").click({ date: date }, prev_year);
        $(".month").click({ date: date }, month_click);
        //$("#add-button").click({ date: date }, new_event);

        // Active le mois en cours
        $(".months-row").children().eq(date.getMonth()).addClass("active-month");

        init_calendar(date);

        //var events = check_slots(today, date.getMonth() + 1, date.getFullYear());
        //show_slots(events, months[date.getMonth()], today);
    });

    // Ajout des dates dans le calendrier
    function init_calendar(date) {
        //vide contenu calendrier et rdv 
        $(".tbody").empty();
        $(".slots-container").empty();

        var calendar_days = $(".tbody");
        var month = date.getMonth();
        var year = date.getFullYear();
        var day_count = days_in_month(month, year);
        var row = $("<tr class='table-row'></tr>");
        var today = date.getDate();
        var dateTable = new Date();
        // pas de décalage
        date.setDate(1);

        //Trouve le 1er lundi à afficher
        var first_day = getFirstDay(date);
        dateTable = first_day;
        //boucle au max pour afficher 42 cases
        //mais si un dimanche de mois+1 est affiché alors fin de la boucle => pas de ligne supplémentaire dans le calendrier
        for (var i = 0; i < 42; i++) {
            var day = dateTable.getDate();

            // Si Lundi à afficher alors changement de ligne
            if (dateTable.getDay() === 1) {
                calendar_days.append(row);
                row = $("<tr class='table-row'></tr>");
            }

            if (dateTable.getMonth() !== month) {
                var curr_date = $("<td class='table-date autre-mois'>" + day + "</td>");
                //row.append(curr_date);
            }
            else {
                //ajoute la case avec la date de ce jour
                var curr_date = $("<td class='table-date'>" + day + "</td>");

                //récup dispo/ouverture du jour
                var events = check_slots(day, month + 1, year);
                /*
                                //test si case du jour et activation si pas déjà une autre
                                if (today === day && $(".active-date").length === 0) {
                                    curr_date.addClass("active-date");
                                    show_slots(events, months[month], day);
                                }
                */
                // si la date a une dispo => flag
                if (events.length !== 0) {
                    curr_date.addClass("event-date");
                }

                // Set onClick handler for clicking a date
                curr_date.click({ events: events, year: date.getFullYear(), month: months[month], day: day }, date_click);
            }

            row.append(curr_date);


            dateTable.setDate(day + 1);

            //Si un dimanche de mois+1 est affiché alors fin de la boucle => pas de ligne supplémentaire dans le calendrier
            if ((dateTable.getDay() === 1) && (dateTable.getMonth() > month)) {
                //fin de la table
                break;

            }
        }
        // Append the last row and set the current year
        calendar_days.append(row);
        $(".year").text(year);
    }

    function getFirstDay(dateToSearch) {
        dateToSearch.setDate(dateToSearch.getDate() - (dateToSearch.getDay() + 6) % 7)
        return dateToSearch;
    }

    // récupère le nbre de jours pour un mois/année donné
    function days_in_month(month, year) {
        var monthStart = new Date(year, month, 1);
        var monthEnd = new Date(year, month + 1, 1);
        return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);
    }

    // Event déclenché si click sur date de table
    function date_click(event) {
        //affichage des plages horaires possible
        $(".slots-container").show(250);
        $("#slots").show(250);

        //bascule de la sélection
        $(".active-date").removeClass("active-date");
        $(this).addClass("active-date");

        //appel de l'affichage des plages
        show_slots(event.data.events, event.data.year, event.data.month, event.data.day);
    };

    // Event déclenché si click sur un mois
    function month_click(event) {
        //affichage de la liste des dispo
        $(".slots-container").show(250);
        $("#slots").hide(250);

        //récup. date en cours d'affichage
        var date = event.data.date;

        //retire le style "active" au mois en cours
        $(".active-month").removeClass("active-month");
        //l'affecte au mois sélectionné
        $(this).addClass("active-month");
        var new_month = $(".month").index(this);

        //mise à jour contenu de table dates
        date.setMonth(new_month);
        init_calendar(date);
    }

    // event déclenché sur btn Left de Année
    function next_year(event) {
        //masque les dispo tant que pas de choix de date
        $("#slots").hide(250);

        //récup. date en cours d'affichage
        var date = event.data.date;

        //année + 1
        var new_year = date.getFullYear() + 1;

        //mise à jour affichage barre supérieure
        $("year").html(new_year);

        //mise à jour contenu de table dates
        date.setFullYear(new_year);
        init_calendar(date);
    }

    // event déclenché sur btn Left de Année
    function prev_year(event) {
        //masque les dispo tant que pas de choix de date
        $("#slots").hide(250);

        //récup. date en cours d'affichage
        var date = event.data.date;

        //année -1
        var new_year = date.getFullYear() - 1;

        //mise à jour affichage barre supérieure
        $("year").html(new_year);

        //mise à jour contenu de table dates
        date.setFullYear(new_year); hide
        init_calendar(date);
    }
    /*
        // Event handler for clicking the new event button
        function new_event(event) {
            // if a date isn't selected then do nothing
            if ($(".active-date").length === 0)
                return;
            // remove red error input on click
            $("input").click(function () {
                $(this).removeClass("error-input");
            })
            // empty inputs and hide events
            $("#slots input[type=text]").val('');
            $("#slots input[type=number]").val('');
            $(".slots-container").hide(250);
            $("#slots").show(250);
            // Event handler for cancel button
            $("#cancel-button").click(function () {
                $("#name").removeClass("error-input");
                $("#count").removeClass("error-input");
                $("#slots").hide(250);
                $(".slots-container").show(250);
            });
            // Event handler for ok button
            $("#confirm-button").unbind().click({ date: event.data.date }, function () {
                var date = event.data.date;
                var name = $("#name").val().trim();
                var count = parseInt($("#count").val().trim());
                var day = parseInt($(".active-date").html());
                // Basic form validation
                if (name.length === 0) {
                    $("#name").addClass("error-input");
                }
                else if (isNaN(count)) {
                    $("#count").addClass("error-input");
                }
                else {
                    $("#slots").hide(250);
                    console.log("new event");
                    new_event_json(name, count, date, day);
                    date.setDate(day);
                    init_calendar(date);
                }
            });
        }*/
    /*
        // enregistrement dans fichier au format json
        function new_event_json(name, count, date, day) {
            var event = {
                "occasion": name,
                "invited_count": count,
                "year": date.getFullYear(),
                "month": date.getMonth() + 1,
                "day": day
            };
            event_data["events"].push(event);
        }
    */
    //Affichage des plages disponibles
    function show_slots(events, year, month, day) {
        // efface les datas existantes dans le container (sélection précédente)
        $(".slots-container").empty();
        $(".slots-container").show(250);

        requestDispo();

        console.log(event_data["events"]);

        // If there are no events for this date, notify the user
        //        if (events.length === 0) {
        var slotCard = $("<div class='slot-card'></div>");
        var slotDate = $("<div class='date-slot'>" + day + " " + month + " " + year + "</div>");
        // $(slotCard).css({ "border-left": "10px solid #FF1744" });
        $(slotCard).append(slotDate);
        $(".slots-container").append(slotCard);
/*        }
        else {
            // Go through and add each event as a card to the events container
            for (var i = 0; i < events.length; i++) {
                var event_card = $("<div class='event-card'></div>");
                var event_name = $("<div class='event-name'>" + events[i]["occasion"] + ":</div>");
                var event_count = $("<div class='event-count'>" + events[i]["invited_count"] + " Invited</div>");
                if (events[i]["cancelled"] === true) {
                    $(event_card).css({
                        "border-left": "10px solid #FF1744"
                    });
                    event_count = $("<div class='event-cancelled'>Cancelled</div>");
                }
                $(event_card).append(event_name).append(event_count);
                $(".slots-container").append(event_card);
            }
        }
    */  }

    // Vérifie si la date a des dispos à afficher
    function check_slots(day, month, year) {
        var events = [];
/*        for (var i = 0; i < event_data["events"].length; i++) {
            var event = event_data["events"][i];
            if (event["day"] === day &&
                event["month"] === month &&
                event["year"] === year) {
                events.push(event);
            }
        }
*/        return events;
    }



    function requestDispo() {
        $.ajax({
            url: '/carte',
            method: 'GET',
            success: function (response) {
                // Utiliser les données de la réponse pour mettre à jour les champs de formulaire
                console.log(response);
                //                $('#champ1').val(response.donnee1);
                //                $('#champ2').val(response.donnee2);
                // ...
            },
            error: function () {
                console.log('Erreur lors de la récupération des données.');
            }
        });
    }

    // Given data for events in JSON format
    var event_data = {
        "events": [
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10,
                "cancelled": true
            },
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10,
                "cancelled": true
            },
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10,
                "cancelled": true
            },
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10
            },
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10,
                "cancelled": true
            },
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10
            },
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10,
                "cancelled": true
            },
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10
            },
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10,
                "cancelled": true
            },
            {
                "occasion": " Repeated Test Event ",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 10
            },
            {
                "occasion": " Test Event",
                "invited_count": 120,
                "year": 2020,
                "month": 5,
                "day": 11
            }
        ]
    };

    const months = [
        "Janv.",
        "Fev.",
        "Mars",
        "Avr.",
        "Mai",
        "Juin",
        "Juil.",
        "Août",
        "Sept.",
        "Oct.",
        "Nov.",
        "Déc."
    ];


})(jQuery);
