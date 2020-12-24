package ep.rest

import java.io.Serializable

data class Toy(
        val artikel_id: Int = 0,
        val artikel_ime: String = "",
        val artikel_cena: Double = 0.0,
        val artikel_opis: String = "",
        val artikel_aktiviran: Boolean = true,
        ) : Serializable