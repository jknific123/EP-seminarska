package ep.rest

import android.os.Bundle
import android.util.Log
import androidx.appcompat.app.AppCompatActivity
import kotlinx.android.synthetic.main.activity_toy_detail.*
import kotlinx.android.synthetic.main.content_toy_detail.*
//import kotlinx.android.synthetic.main.content_toy_detail.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class ToyDetailActivity : AppCompatActivity() {
    private var toy: Toy = Toy()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_toy_detail)
        setSupportActionBar(toolbar)


        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        val id = intent.getIntExtra("ep.rest.id", 0)

        if (id > 0) {
            ToyService.instance.get(id).enqueue(OnLoadCallbacks(this))
        }
    }


    private class OnLoadCallbacks(val activity: ToyDetailActivity) : Callback<Toy> {
        private val tag = this::class.java.canonicalName

        override fun onResponse(call: Call<Toy>, response: Response<Toy>) {
            activity.toy = response.body() ?: Toy()

            Log.i(tag, "Got result: ${activity.toy}")

            if (response.isSuccessful) {
                activity.tvToyDetail.text = activity.toy.artikel_opis
                activity.toolbarLayout.title = activity.toy.artikel_ime
            } else {
                val errorMessage = try {
                    "An error occurred: ${response.errorBody()?.string()}"
                } catch (e: IOException) {
                    "An error occurred: error while decoding the error message."
                }

                Log.e(tag, errorMessage)
                activity.tvToyDetail.text = errorMessage
            }
        }

        override fun onFailure(call: Call<Toy>, t: Throwable) {
            Log.w(tag, "Error: ${t.message}", t)
        }
    }
}

