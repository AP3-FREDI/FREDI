package com.ramiara.top14client;
//
// Top 14 client
//
// Tâche asynchrone lancée depuis ListActivity
// NOTA : on est obligé de lancer une tâche asynchrone car la connexion Internet peut prendre
// un certain temps, ce qui bloquerait ListActivity

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

public class MyAsyncTask extends AsyncTask<String, Void, String> {

    public static final String EXTRA_MESSAGE = "com.ramiara.top14client.MESSAGE";

    // http://localhost/projets/top14server/clubs.php?user=jef&password=jefjef
    String MyURL = "http://192.168.1.18/projets/top14server/clubs.php";
    //String MyUser = "jef";
    String MyUser;
    //String MyPassword = "jefjef";
    String MyPassword;
    ListView myListView;
    Context myContext;
    ArrayList<Club> myClubs = new ArrayList<>();
    ArrayList<String> myArrayList = new ArrayList<>();
    Activity myActivity;

    /**
     * Constructeur
     * @param listView la listView qui va recevoir le contenu
     */
    public MyAsyncTask(ListView listView, Activity activity) {
        super();
        myListView = listView;
        myContext = listView.getContext();
        myActivity = activity;
    }

    /**
     * Quand on lance la tâche asynchrone (.execute() dans ListActivity)
     * @param authentification le login et le mot de passe
     * @return Chaîne JSON
     */
    @Override
    protected String doInBackground(String... authentification) {
        MyUser = authentification[0];
        MyPassword = authentification[1];

        String url = MyURL + "?user=" + MyUser + "&password=" + MyPassword;
        Log.d(MainActivity.LOG_TAG, "URL=" + url);
        // Accède à Internet, consomme un service Web en RESTful et renvoie un contenu JSON
        return NetworkUtils.request(url);
    }

    /**
     * Quand la tâche asynchrone est terminée
     * @param jsonString le contenu JSON renvoyé par la méthode doInBackground()
     */
    @Override
    protected void onPostExecute(String jsonString) {
        super.onPostExecute(jsonString);

        // Interprète le contenu JSON pour récupérer le token
        if (jsonString != null) {
            try {
                // Récupère le contenu du fichier JSON
                JSONObject jsonObject = new JSONObject(jsonString);
                String message = jsonObject.getString("message");
                Log.d(MainActivity.LOG_TAG, "message=" + message);  // Tests seulement
                // Récupère la liste des clubs
                if (jsonObject.isNull("clubs")==false) {
                    JSONArray clubsArray = jsonObject.getJSONArray("clubs");
                    // Boucle de lecture des clubs
                    for (int i = 0; i < clubsArray.length(); i++) {
                        JSONObject clubJsonObject = clubsArray.getJSONObject(i);
                        // Crée un objet métier Club à partir de l'objet JSONObject
                        Club club = new Club(clubJsonObject);
                        // Ajoute l'objet métier dans la collection ArrayList<Club>
                        myClubs.add(club);
                        // Ajoute le libellé du club dans la collection ArrayList<String>
                        myArrayList.add(club.nom);
                        // Affiche un message en bas de liste
                        TextView textView = (TextView) myActivity.findViewById(R.id.tv_message);
                        textView.setText(String.valueOf(clubsArray.length()) + " club(s)");

                    }
                } else {
                    // Pas de liste club à afficher
                    myArrayList.add("Rien à afficher !");
                    Toast.makeText(myContext, "Rien à afficher !", Toast.LENGTH_LONG).show();
                    Log.d(MainActivity.LOG_TAG, "Rien à afficher");
                    // Affiche un message en bas de liste
                    TextView textView = (TextView) myActivity.findViewById(R.id.tv_message);
                    textView.setText("Rien à afficher");

                }

            } catch (Exception e) {
                Log.d(MainActivity.LOG_TAG, "Erreur lors de la lecture du fichier JSON");
                e.printStackTrace();
            }
        } else {
            Log.d(MainActivity.LOG_TAG, "Erreur : le fichier JSON est vide !");
        }

        // Remplit la listView
        // Crée l'adaptateur
        final ArrayAdapter<String> myAdapter = new ArrayAdapter<>(myContext, android.R.layout.simple_list_item_1, myArrayList);

        // Associe l'adapteur à la listView
        myListView.setAdapter(myAdapter);

        // Ajoute un gestionnaire d'événement sous la forme d'une classe anonyme
        myListView.setOnItemClickListener(
                new AdapterView.OnItemClickListener() {
                    @Override
                    public void onItemClick(AdapterView<?> adapterView, View view, int position, long l) {
                        // Instancie le club pointé par le clic sur la listView
                        Club myClub = myClubs.get(position);
                        // Transforme l'objet Club en array (tableau) pour pouvoir fournir les détails à l'activity suivante
                        // NOTA : les intents n'acceptent pas les objets, seulement des strings et des array de strings
                        String myData[] = myClub.toArray();
                        // Création de l'intent pour DetailsActivity
                        Intent myIntent = new Intent(myContext, DetailsActivity.class);
                        // Ajoute dans l'intent le tableau contenant les détails du club
                        myIntent.putExtra(EXTRA_MESSAGE, myData);
                        // Lancement de l'activité
                        myActivity.startActivity(myIntent);
                        // test
                        String chaine = myAdapter.getItem(position);
                        Log.d(MainActivity.LOG_TAG, "Clic sur" + chaine);
                    }
                }
        );

    }
}
