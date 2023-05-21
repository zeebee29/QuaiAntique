


document.addEventListener("DOMContentLoaded", function () {

    const months = ["Janv.", "Fev.", "Mars", "Avr.", "Mai", "Juin", "Juil.", "Août", "Sept.", "Oct.", "Nov.", "Déc."];

    const btnLeft = document.getElementById('prev-year');
    const btnRight = document.getElementById('next-year');
    const labelYear = document.getElementById('year');

    const btnMonth = document.getElementsByClassName('month');
    const listMonth = document.getElementById('month-list');

    const tabDate = document.getElementById('tbody');

    const slotsCont = document.getElementById('slots-cont');
    const slotCard = document.getElementById('slot-card');
    const dateSlot = document.getElementById('date-slot');
    //const slotsPart1 = document.getElementById('slots-part1');
    const sstitre1 = document.getElementById('sstitre1');
    const msgSlot1 = document.getElementById('msg-slot1');
    const tb1Plages = document.getElementById('tb1-plages');
    //const slotsPart2 = document.getElementById('slots-part2');
    const sstitre2 = document.getElementById('sstitre2');
    const msgSlot2 = document.getElementById('msg-slot2');
    const tb2Plages = document.getElementById('tb2-plages');


    let date = new Date();
    for (let i = 0; i < btnMonth.length; i++) {
        btnMonth[i].addEventListener(
            "click",
            function (event) {
                handleClickMonth(event, date, i);
            });
    }
    btnLeft.addEventListener('click', function (event) { handleClickPrevYear(date); });
    btnRight.addEventListener('click', function (event) { handleClickNextYear(date); });

    // init : affichage du mois en cours
    btnMonth[date.getMonth()].classList.add("active-month");

    initCalendar(date);

    function initCalendar(date) {

        var dataResa = document.getElementById('dataResa');
        var tab = dataResa.getAttribute('data1');
        var tabFull = JSON.parse(tab);
        var tab = dataResa.getAttribute('data2');
        var tabClosed = JSON.parse(tab);
        var tab = dataResa.getAttribute('data3');
        var tabSlots = JSON.parse(tab);
        console.log('Plages HS:', tabFull.length, tabFull);
        console.log('H hebdo:', tabClosed.length, tabClosed);
        console.log('Plages H:', tabSlots.length, tabSlots);

        //vide le contenu calendrier et les dispo 
        //$(".tbody").empty();
        if (tabDate) {
            supprChildren(tabDate);
        }
        //$(".slots-container").empty();

        //var calendar_days = tabDate;
        var calendar_days = document.getElementById("tbody");
        var month = date.getMonth();
        var year = date.getFullYear();
        //var day_count = days_in_month(month, year);

        /*var row = document.createElement("tr");
        row.classList.add("table-row");
*/
        var dateTable = new Date();

        // pas de décalage
        date.setDate(1);

        //Trouve le 1er lundi à afficher
        console.log("1ERE DATE : ", date)
        var first_day = getFirstDay(date);
        dateTable = first_day;
        //boucle au max pour afficher 42 cases
        //mais si un dimanche de mois+1 est affiché alors fin de la boucle => pas de ligne supplémentaire dans le calendrier
        for (var i = 0; i < 42; i++) {
            var day = dateTable.getDate();
            var numJsem = dateTable.getDay();
            // Si Lundi à afficher alors changement de ligne
            if (numJsem === 1) {
                var row = document.createElement("tr");
                row.classList.add("table-row");
                calendar_days.appendChild(row);
            }

            if (dateTable.getMonth() !== month) {
                var curr_date = document.createElement("td");
                curr_date.className = "table-date autre-mois";
                curr_date.textContent = day;
                row.appendChild(curr_date);

                //row.append(curr_date);
            }
            else {
                let curr_date = document.createElement("td");
                curr_date.className = "table-date";
                curr_date.textContent = day;
                row.appendChild(curr_date);


                //récup dispo/ouverture du jour
                //var fermeture = check_slots(day, month + 1, year);
                //                    //test si case du jour et activation si pas déjà une autre
                //                   if (today === day && $(".active-date").length === 0) {
                //                       curr_date.addClass("active-date");
                //                       show_slots(events, months[month], day);
                //                   }
                //               
                // si la date a une dispo => flag
                //                if (events.length !== 0) {
                //                    curr_date.addClass("event-date");
                //                }

                // Set onClick handler for clicking a date
                //                curr_date.click({ events: events, year: date.getFullYear(), month: months[month], day: day }, date_click);
                var options = { weekday: 'short' };
                //substring pour être sûr de ne pas avoir de caractère supplémentaire
                var nomJsem = dateTable.toLocaleDateString('fr-FR', options).substring(0, 3);
                var monthFormated = String(dateTable.getMonth() + 1).padStart(2, '0');
                var dayFormated = String(dateTable.getDate()).padStart(2, '0');

                var eventHandler = date_click(
                    date.getFullYear(),
                    months[month],
                    monthFormated,
                    day,
                    dayFormated,
                    nomJsem,
                    tabFull,
                    tabClosed,
                    tabSlots
                );

                curr_date.addEventListener("click", eventHandler);
            }


            var date2 = new Date(dateTable.getFullYear(), dateTable.getMonth(), dateTable.getDate() + 1);
            //Si un dimanche de mois+1 est affiché alors fin de la boucle => pas de ligne supplémentaire dans le calendrier
            if ((date2.getDay() === 1) && (date2.getMonth() > month)) {
                //fin de la table
                break;
            }
            dateTable.setDate(day + 1);
        }
        // Append the last row and set the current year
        var rown = document.createElement("tr");
        rown.classList.add("table-row");
        calendar_days.appendChild(rown);
        labelYear.textContent = year;
    }

    function getFirstDay(dateToSearch) {
        dateToSearch.setDate(dateToSearch.getDate() - (dateToSearch.getDay() + 6) % 7)
        return dateToSearch;
    }

    // Event déclenché si click sur date de table
    function date_click(year,
        month,
        monthNum,
        day,
        dayNum,
        nomJsem,
        tabFull,
        tabClosed,
        tabSlots
    ) {
        return function (event) {
            console.log("TARGET", event.target)
            //Activation du conteneur pour affichage des plages horaires
            slotsCont.style.display = window.getComputedStyle(slotsCont).getPropertyValue("display");
            console.log("NOS DISPO2 : ", year + '-' + monthNum + '-' + dayNum)
            //console.log("TabDate : ", dateTable)
            clickedElement = event.currentTarget;
            //efface toutes les ligne d'horaires déjà affichées (si existe)
            var elements = document.querySelectorAll('.line-h');
            console.log("Ligne existante", elements);
            for (var i = 0; i < elements.length; i++) {
                elements[i].remove();
            };
            console.log("Ligne supprimée ?", elements);

            //slotsPart1.style.display = window.getComputedStyle(slotsPart1).getPropertyValue("display");
            //$(".slots-container").show(250);
            //$("#slots").show(250);

            //bascule de la sélection
            supprClass("active-date");
            clickedElement.classList.add("active-date");

            //appel de l'affichage des plages
            //        show_slots(event.data.events, event.data.year, event.data.month, event.data.day);
            show_slots(
                year,
                month,
                monthNum,
                day,
                dayNum,
                nomJsem,
                tabFull,
                tabClosed,
                tabSlots,
            );
        };
    }


    /* Test si les plages "midi" ou "soir" sont des plages d'ouverture du restau
    retour : 
        0 : si aucune fermeture
        1 : si midi fermé
        2 : si soir fermé
        3 : si midi + soir fermé
    */
    function testFermeture(jSem, tabFermeture) {
        var fermeture = 0;
        console.log("Fermeture : ", tabFermeture);
        console.log("Jour demandé :", jSem)
        for (var i = 0; i < tabFermeture.length; i++) {
            if (tabFermeture[i].jour.toLowerCase() === jSem) {

                if (tabFermeture[i].plage == "midi") {
                    fermeture += 1;
                }
                if (tabFermeture[i].plage == "soir") {
                    fermeture += 2;
                }
            }
            if (fermeture === 3) {
                //pas la peine de continuer
                break;
            }
        }
        return fermeture;
    }


    /* Test si une des plages "midi ou soir" du jour sélectionné fait partie de la liste
    des plages déclarées complètes.
    retour : 
        0 : si aucun complet
        1 : si midi complet
        2 : si soir complet
        3 : si midi + soir complets
    */
    function testDispoJour(date, tabDate) {
        var completude = 0;
        for (var i = 0; i < tabDate.length; i++) {
            if (tabDate[i].jour === date) {
                if (tabDate[i].plage == "midi") {
                    completude += 1;
                }
                if (tabDate[i].plage == "soir") {
                    completude += 2;
                }
            }
            if (completude === 3) {
                //pas la peine de continuer
                break;
            }
        }
        return completude;
    }

    /* Affichage des plages de réservations suivant ouverture et dispo
     
    */
    function affPlages(fermeture, completude, tabPlages) {
        if (fermeture === 3) {
            //Affiche 1x "Fermé" pour tout le jour
            console.log("Jour Fermé");

            //Ajout de la div "infoStatus" à
            msgSlot1.textContent = 'Fermé';
            msgSlot2.textContent = '';
            sstitre1.textContent = '';
            sstitre2.textContent = '';
        }
        else {
            msgSlot1.textContent = '';
            msgSlot2.textContent = '';

            //Affiche les horaires pour les 2 plages
            sstitre1.textContent = 'Midi';
            sstitre2.textContent = 'Soir';
            affPlage("midi", fermeture, completude, tabPlages, msgSlot1, tb1Plages);
            affPlage("soir", fermeture, completude, tabPlages, msgSlot2, tb2Plages);
        }
    }

    /* Affichage dans la plage passée en paramètre :
    - "Fermé" si la 1/2j est fermée
    - "Complet" si 1/2j complète
    - Heure des plages de réservation de la 1/2j dans tous les autres cas.
    */
    function affPlage(plage, fermeture, completude, tabPlages, msgSlotx, tbxPlages) {
        if (((plage == "midi") && (fermeture === 1))
            || ((plage == "soir") && (fermeture === 2))) {
            // affiche "Fermé" pour la 1/2 journée
            msgSlotx.textContent = 'Fermé';
            console.log(plage, " : Fermé");
        }
        else if (((plage == "midi") && (completude === 1))
            || ((plage == "soir") && (completude === 2))) {
            // affiche "Complet" pour la 1/2 journée
            msgSlotx.textContent = 'Complet';
            console.log(plage, " : Complet");
        }
        else {
            if (plage === "midi") {
                ligneTable = creationTable('line1-h', tbxPlages)
            }
            else {
                ligneTable = creationTable('line2-h', tbxPlages)
            }
            for (var i = 0; i < tabPlages.length; i++) {
                if (tabPlages[i].plage === plage) {
                    // affiche toutes les plages horaires de la 1/2 journée demandée
                    console.log(plage, " XX:XX");
                    var plageN = document.createElement('td');
                    plageN.textContent = tabPlages[i].heure;
                    plageN.setAttribute('id', plage + "-" + i)
                    plageN.classList.add('slot-h');
                    plageN.addEventListener('click', handleClickHeure);
                    ligneTable.appendChild(plageN)
                }
            }
        }
    }

    function creationTable(idLigne, tbPlages) {
        //normalement c'est déjà fait, mais au cas où, effecement
        const test = document.getElementById(idLigne);
        if (test !== null) {
            test.remove();
        }

        const lignex = document.createElement('tr');
        lignex.classList.add('line-h');
        lignex.setAttribute('id', idLigne);
        //attache à <tablex>
        tbPlages.appendChild(lignex);
        return lignex;
    }

    function handleClickHeure(event) {
        const clickedElement = event.currentTarget;
        const clickedId = clickedElement.id;
        console.log("Clic sur : ", clickedElement.textContent, clickedId);
        supprClass("active-slot");
        clickedElement.classList.add("active-slot");
    }

    function supprClass(classe) {
        const elements = document.getElementsByClassName(classe);
        for (let i = 0; i < elements.length; i++) {
            elements[i].classList.remove(classe);
        }
    }


    function handleClickNextYear(date) {
        //année + 1
        var new_year = date.getFullYear() + 1;

        //mise à jour affichage barre supérieure
        labelYear.textContent = new_year;
        //mise à jour contenu de table dates
        date.setFullYear(new_year);

        initCalendar(date);
    }

    function handleClickPrevYear(date) {
        //année -1
        var new_year = date.getFullYear() - 1;

        //mise à jour affichage barre supérieure
        labelYear.textContent = new_year;
        //mise à jour contenu de table dates
        date.setFullYear(new_year);

        initCalendar(date);
    }

    function handleClickMonth(event, date, index) {
        currentElement = event.currentTarget;
        //retire le style "active" au mois en cours
        supprClass("active-month");
        //l'affecte au mois sélectionné
        currentElement = event.currentTarget;
        currentElement.classList.add("active-month");

        //mise à jour contenu de table dates
        date.setMonth(index);

        initCalendar(date);
    }



    function supprChildren(parent) {
        while (parent.firstChild) {
            parent.firstChild.remove()
        }
    }


    //Affichage des plages disponibles
    function show_slots(
        year,
        month,
        monthNum,
        day,
        dayNum,
        nomJsem,
        tabFull,
        tabClosed,
        tabSlots,
    ) {
        slotCard.textContent = "Nos diponibilités pour le";
        console.log("NOS DISPO3 : ", year + '-' + monthNum + '-' + dayNum)
        var date = year + '-' + monthNum + '-' + dayNum;
        dateSlot.textContent = day + " " + month + " " + year;

        /*Données d'entrée 
        console.log('Plages completes:', tabFull.length, tabFull);
        console.log('H hebdo:', tabClosed.length, tabClosed);
        console.log('Plages H:', tabSlots.length, tabSlots);        
        /* Test si les plages "midi" ou "soir" sont des plages d'ouverture du restau */
        const statusClosed = testFermeture(nomJsem, tabClosed);

        /* Test si une des plages "midi ou soir" du jour sélectionné fait 
        partie de la liste des plages déclarées complètes. */
        const statusFull = testDispoJour(date, tabFull);
        /* Affichage des plages de réservations suivant ouverture et dispo */
        affPlages(statusClosed, statusFull, tabSlots)

    }

    // Vérifie si la date a des dispos à afficher
    function check_slots(day, month, year) {
        //parcours de tabClosed pour griser le calendrier
        /*
        for (var i = 0; i < tabclosed.length; i++) {
        }
         
        return events;*/
    }



});
