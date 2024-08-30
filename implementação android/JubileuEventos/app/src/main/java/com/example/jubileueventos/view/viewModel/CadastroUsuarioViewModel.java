package com.example.jubileueventos.view.viewModel;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.repository.UsuarioRepository;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class CadastroUsuarioViewModel extends ViewModel {
    private UsuarioRepository usuarioRepository;
    private MutableLiveData<Boolean> mResultado;

    public CadastroUsuarioViewModel() {
        this.usuarioRepository = new UsuarioRepository();
        this.mResultado = new MutableLiveData<>();
    }

    public MutableLiveData<Boolean> getResultado() {
        return mResultado;
    }

    public void inserirUsuario(Usuario usuario) {
        this.usuarioRepository.inserirUsuario(usuario, new Callback<Usuario>() {
            @Override
            public void onResponse(Call<Usuario> call, Response<Usuario> response) {
                Usuario usuario = response.body();

                try {
                    if (usuario.getIdUsuario() > 0) {
                        mResultado.postValue(true);
                    } else {
                        mResultado.postValue(false);
                    }
                } catch (Exception e) {
                    mResultado.postValue(false);
                }
            }

            @Override
            public void onFailure(Call<Usuario> call, Throwable t) {
                mResultado.postValue(false);
            }
        });
    }
}











