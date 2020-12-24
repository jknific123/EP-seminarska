package ep.rest

import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.*

object ToyService {

    interface RestApi {

        companion object {
            // AVD emulator
            const val URL = "http://10.0.2.2:8080/netbeans/EP-seminarska/index.php/api/"
        }


        @GET("store")
        fun getAll(): Call<List<Toy>>

        @GET("store/{id}")
        fun get(@Path("id") id: Int): Call<Toy>
    }

    val instance: RestApi by lazy {
        val retrofit = Retrofit.Builder()
                .baseUrl(RestApi.URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build()

        retrofit.create(RestApi::class.java)
    }
}
