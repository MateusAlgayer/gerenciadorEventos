package com.example.jubileueventos.repository;

import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.retrofit.ClienteRetrofit;
import com.example.jubileueventos.retrofit.UsuarioService;

import retrofit2.Callback;

public class UsuarioRepository {
    private  final UsuarioService usuarioService = ClienteRetrofit.getInstance().create(UsuarioService.class);

    public void inserirUsuario(Usuario usuario, Callback<Usuario> callback) {
        usuarioService.inserirUsuario(usuario).enqueue(callback);
    }

    public void autenticarUsuario(Usuario usuario, Callback<Usuario> callback) {
        usuarioService.autenticarUsuario(usuario).enqueue(callback);
    }
}
