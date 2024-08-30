package com.example.jubileueventos.retrofit;

import com.example.jubileueventos.modelDominio.Usuario;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;

public interface UsuarioService {
    @POST("usuario/inserir")
    Call<Usuario> inserirUsuario(@Body Usuario usuario);

    @POST("login")
    Call<Usuario> autenticarUsuario(@Body Usuario usuario);
}
