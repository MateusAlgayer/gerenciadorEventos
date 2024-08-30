package com.example.jubileueventos.view.viewModel;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.jubileueventos.modelDominio.Usuario;

public class VisualizaUsuarioViewModel extends ViewModel {
    private MutableLiveData<Usuario> mUsuario;

    public VisualizaUsuarioViewModel() {
        this.mUsuario = new MutableLiveData<>();
    }

    public MutableLiveData<Usuario> getUsuario() {
        return mUsuario;
    }

    public void setUsuario(Usuario usuario) {
        this.mUsuario.setValue(usuario);
    }
}






