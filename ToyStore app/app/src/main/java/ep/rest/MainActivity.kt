package ep.rest

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.AdapterView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import kotlinx.android.synthetic.main.activity_main.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class MainActivity : AppCompatActivity(), Callback<List<Toy>> {
    private val tag = this::class.java.canonicalName

    private lateinit var adapter: ToyAdapter

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        adapter = ToyAdapter(this)
        items.adapter = adapter
        items.onItemClickListener = AdapterView.OnItemClickListener { _, _, i, _ ->
            val toy = adapter.getItem(i)
            if (toy != null) {
                val intent = Intent(this, ToyDetailActivity::class.java)
                intent.putExtra("ep.rest.id", toy.artikel_id)
                startActivity(intent)
            }
        }

        container.setOnRefreshListener { ToyService.instance.getAll().enqueue(this) }

        ToyService.instance.getAll().enqueue(this)
    }

    override fun onResponse(call: Call<List<Toy>>, response: Response<List<Toy>>) {
        if (response.isSuccessful) {
            val hits = response.body() ?: emptyList()
            Log.i(tag, "Got ${hits.size} hits")
            adapter.clear()
            adapter.addAll(hits)
        } else {
            val errorMessage = try {
                "An error occurred: ${response.errorBody()?.string()}"
            } catch (e: IOException) {
                "An error occurred: error while decoding the error message."
            }

            Toast.makeText(this, errorMessage, Toast.LENGTH_SHORT).show()
            Log.e(tag, errorMessage)
        }
        container.isRefreshing = false
    }

    override fun onFailure(call: Call<List<Toy>>, t: Throwable) {
        Log.w(tag, "Error: ${t.message}", t)
        container.isRefreshing = false
    }
}
