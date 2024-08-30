package com.example.jubileueventos.view.fragments;

import androidx.lifecycle.Observer;
import androidx.lifecycle.ViewModelProvider;

import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.navigation.Navigation;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import com.example.jubileueventos.R;
import com.example.jubileueventos.databinding.FragmentCadastroUsuarioBinding;
import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.utils.Validador;
import com.example.jubileueventos.view.viewModel.CadastroUsuarioViewModel;

public class CadastroUsuarioFragment extends Fragment {

    private CadastroUsuarioViewModel mViewModel;
    FragmentCadastroUsuarioBinding binding;
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        binding = FragmentCadastroUsuarioBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        mViewModel = new ViewModelProvider(this).get(CadastroUsuarioViewModel.class);

        // definindo o observador do retorno do cadastro
        mViewModel.getResultado().observe(getViewLifecycleOwner(),observaCadastroUsuario);

        // programando o clique nos botões
        binding.bCadastroSalvar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                // verificando se o usuário informou os addos
                if (!Validador.validaTexto(binding.etCadastroUsuarioNome.getText().toString())) {
                    binding.etCadastroUsuarioNome.setError("Erro: informe o nome.");
                    binding.etCadastroUsuarioNome.requestFocus();
                    return;
                }
                if (!Validador.validaEmail(binding.etCadastroUsuarioEmail.getText().toString())) {
                    binding.etCadastroUsuarioEmail.setError("Erro: informe o email.");
                    binding.etCadastroUsuarioEmail.requestFocus();
                    return;
                }

                /*
                if (!Validador.validaTexto(binding.etCadastroUsuarioLogin.getText().toString())) {
                    binding.etCadastroUsuarioLogin.setError("Erro: informe o login.");
                    binding.etCadastroUsuarioLogin.requestFocus();
                    return;
                }
                */

                if (!Validador.validaTexto(binding.etCadastroUsuarioSenha.getText().toString())) {
                    binding.etCadastroUsuarioSenha.setError("Erro: informe a senha.");
                    binding.etCadastroUsuarioSenha.requestFocus();
                    return;
                }

                // obtendo as informações
                String nome = binding.etCadastroUsuarioNome.getText().toString();
                String email = binding.etCadastroUsuarioEmail.getText().toString();
                String login = binding.etCadastroUsuarioLogin.getText().toString();
                String senha = binding.etCadastroUsuarioSenha.getText().toString();

                Usuario usuario = new Usuario(nome,email,login,senha);

                mViewModel.inserirUsuario(usuario);
            }
        });

        binding.bCadastroCancelar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                limpaCampos();
            }
        });
    }

    Observer<Boolean> observaCadastroUsuario = new Observer<Boolean>() {
        @Override
        public void onChanged(Boolean aBoolean) {
            if (aBoolean) {
                Toast.makeText(getContext(), "usuário cadastrado com sucesso!", Toast.LENGTH_SHORT).show();
                limpaCampos();
                Navigation.findNavController(requireView()).popBackStack();
            } else {
                Toast.makeText(getContext(), "Erro: usuário não cadastrado.", Toast.LENGTH_SHORT).show();
            }
        }
    };
    public void limpaCampos() {
        binding.etCadastroUsuarioNome.setText("");
        binding.etCadastroUsuarioEmail.setText("");
        binding.etCadastroUsuarioLogin.setText("");
        binding.etCadastroUsuarioSenha.setText("");
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }



}