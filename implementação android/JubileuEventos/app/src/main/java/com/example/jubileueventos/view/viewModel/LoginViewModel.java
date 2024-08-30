package com.example.jubileueventos.view.viewModel;

import android.widget.Toast;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.repository.UsuarioRepository;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LoginViewModel extends ViewModel {
    private UsuarioRepository usuarioRepository;
    private MutableLiveData<Usuario> mUsuarioLogado;

    public LoginViewModel() {
        this.usuarioRepository = new UsuarioRepository();
        this.mUsuarioLogado = new MutableLiveData<>();
    }

    public MutableLiveData<Usuario> getUsuarioLogado() {
        return mUsuarioLogado;
    }

    // método para limpar o usuário logado
    public void limpaEstado() {
        mUsuarioLogado = new MutableLiveData<>();
    }

    public void efetuarLoginUsuario(Usuario usuario) {
        this.usuarioRepository.autenticarUsuario(usuario, new Callback<Usuario>() {
            @Override
            public void onResponse(Call<Usuario> call, Response<Usuario> response) {
                Usuario usuario = response.body();

                try {
                    if (usuario.getIdUsuario() > 0) {
                        mUsuarioLogado.postValue(usuario);
                    } else {
                        mUsuarioLogado.postValue(null);
                    }
                } catch (Exception e) {
                    mUsuarioLogado.postValue(null);
                }
            }

            @Override
            public void onFailure(Call<Usuario> call, Throwable t) {
                mUsuarioLogado.postValue(null);
            }
        });
    }
}












