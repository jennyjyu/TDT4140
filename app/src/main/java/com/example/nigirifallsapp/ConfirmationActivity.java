package com.example.nigirifallsapp;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.support.design.widget.NavigationView;
import android.support.v4.app.NavUtils;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.Gravity;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.RatingBar;
import android.widget.TextView;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;


public class ConfirmationActivity extends AppCompatActivity {
    private String orderID = "Sorry, something went wrong";
    private String statusText = "Order Status: ";
    private TextView statusTextView;
    private String orderStatus = "Error";
    private String pickUpTime = "68:23:20";
    RequestQueue requestQueue;
    private int hourOfDay;
    private int min;
    private DrawerLayout drawerLayout;



    Thread thread = new Thread() {
        @Override
        public void run() {
            int count = 0;
            while(count < 100) {
                try {
                    Thread.sleep(5000);
                } catch (InterruptedException e) {
                }

                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        requestOrderInfo();
                    }
                });
                count += 1;
            }
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.initOrderID();
        setContentView(R.layout.confirmation_activity_layout);

        Intent intent = this.getIntent();
        Bundle extras = intent.getExtras();
        this.hourOfDay = extras.getInt(PickupActivity.HourIntent);
        this.min = extras.getInt(PickupActivity.MinIntent);
        this.orderID = extras.getString(PickupActivity.OrderIDIntent);

        this.requestQueue = Volley.newRequestQueue(this);
        TextView textView2 = findViewById(R.id.textView2);
        String text = "Your order has been registered! Ready for pickup in about 30 min. \n\n\nYour pickup reference is: \n\n ";
        text += getOrderID() +"\n\n\n\n";
        textView2.setTextColor(getResources().getColor(R.color.textColorDark));
        textView2.setText(text);
        textView2.setTextSize(18);

        this.drawerLayout = findViewById(R.id.drawer_layout);

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        ActionBar actionBar = getSupportActionBar();
        actionBar.setDisplayHomeAsUpEnabled(true);
        actionBar.setHomeAsUpIndicator(R.drawable.icon_menu);
        NavigationView navigationView = findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(
                new NavigationView.OnNavigationItemSelectedListener() {
                    @Override
                    public boolean onNavigationItemSelected(MenuItem menuItem) {
                        // set item as selected to persist highlight
                        menuItem.setChecked(true);
                        // close drawer when item is tapped
                        drawerLayout.closeDrawers();

                        // Add code here to update the UI based on the item selected
                        // For example, swap UI fragments here

                        return true;
                    }
                });

        //Order status
        this.statusTextView = findViewById(R.id.textView4);
        String status = statusText + "Waiting";
        statusTextView.setText(status);
        statusTextView.setTextColor(getResources().getColor(R.color.waitingColor));
        statusTextView.setTextSize(24);
        thread.start();
        requestReview();
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                drawerLayout.openDrawer(GravityCompat.START);
                return true;
        }
        return super.onOptionsItemSelected(item);
    }

    private void initOrderID() {
        String newOrderID = getIntent().getStringExtra("OrderID");

        if (newOrderID != null) {
            this.orderID = newOrderID.replaceAll("\\s","");
            System.out.print(this.orderID);
        }
    }

    private String getOrderID() {
        return this.orderID;
    }
    private String getOrderStatus() {
        return this.orderStatus;
    }

    private String getPickUpTime() {
        return this.pickUpTime;
    }

    private void requestOrderInfo() {
        String url = "http://org.ntnu.no/nigiriapp/getorder.php/?OrderID="; // Change URL
        url += getOrderID();
        sendRequest(url);
    }

    // Function for sending a HTTP request to the PHP-script
    private void sendRequest(String url) {
        // The requests are sent in cleartext over HTTP. Use HTTPS when sending passwords.
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                onActualResponse(response); // The extra function is needed because of the scope of the @Override function
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        });

        requestQueue.add(stringRequest);
    }

    private void onActualResponse(String response) {
        String[] orderInfo = response.split("\\|");
        this.pickUpTime = orderInfo[1];
        this.orderStatus = orderInfo[2];
        updateOrderInfo();
    }

    private void updateOrderInfo() {
        String status = statusText + orderStatus;
        statusTextView.setText(status);

        switch (orderStatus) {
            case "Waiting":
                statusTextView.setTextColor(getResources().getColor(R.color.waitingColor));
                requestReview();
                break;
            case "Confirmed":
                statusTextView.setTextColor(getResources().getColor(R.color.confirmedColor));
                break;
            case "Pickup-ready":
                statusTextView.setTextColor(getResources().getColor(R.color.pickupColor));
                break;
            case "Canceled":
                statusTextView.setTextColor(getResources().getColor(R.color.canceledColor));
                break;
        }
    }

    @Override
    public void onBackPressed() {
        if (this.drawerLayout.isDrawerOpen(GravityCompat.START)) {
            this.drawerLayout.closeDrawer(GravityCompat.START);
        } else {
            NavUtils.navigateUpFromSameTask(this);
        }
    }

    public void requestReview() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);

        LinearLayout ll = new LinearLayout(this);
        ll.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.WRAP_CONTENT, LinearLayout.LayoutParams.WRAP_CONTENT, 0));
        ll.setOrientation(LinearLayout.VERTICAL);
        ll.setGravity(Gravity.CENTER_HORIZONTAL);

        RatingBar rb = new RatingBar(this);
        rb.setNumStars(5);
        rb.setRating(3.5f);
        rb.setMax(5);
        rb.setStepSize(0.5f);
        rb.setLayoutParams(new FrameLayout.LayoutParams(FrameLayout.LayoutParams.WRAP_CONTENT, FrameLayout.LayoutParams.WRAP_CONTENT, 1));
        ll.addView(rb);


        EditText review = new EditText(this);
        review.setGravity(Gravity.CENTER_HORIZONTAL);
        review.setLayoutParams(new FrameLayout.LayoutParams(FrameLayout.LayoutParams.WRAP_CONTENT, FrameLayout.LayoutParams.WRAP_CONTENT,1));
        ll.addView(review);

        builder.setMessage("Please leave us a review!")
                .setPositiveButton("Submit", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                    }
                }).setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });
        builder.setView(ll);
        AlertDialog dialog = builder.create();
        dialog.show();
        TextView messageView = (TextView)dialog.findViewById(android.R.id.message);
        messageView.setGravity(Gravity.CENTER);
        messageView.setTextSize(20);
    }

}
