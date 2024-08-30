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
import com.example.jubileueventos.databinding.FragmentLoginBinding;
import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.utils.Validador;
import com.example.jubileueventos.view.activities.MainActivity;
import com.example.jubileueventos.view.viewModel.InformacoesViewModel;
import com.example.jubileueventos.view.viewModel.LoginViewModel;

public class LoginFragment extends Fragment {

    private LoginViewModel mViewModel;

    InformacoesViewModel informacoesViewModel;
    FragmentLoginBinding binding;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        binding = FragmentLoginBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        mViewModel = new ViewModelProvider(this).get(LoginViewModel.class);

        // obtendo o viewmodelo de compartilhamento de informações
        informacoesViewModel = new ViewModelProvider(getActivity()).get(InformacoesViewModel.class);

        // definindo o observador da autenticação do usuário
        mViewModel.getUsuarioLogado().observe(getViewLifecycleOwner(), observaAuntenticacaoUsuario);

        // programando o clique nos botões
        binding.bLoginEntrar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                // verificando se o usuário informou os dados
                if (!Validador.validaTexto(binding.etLoginUsuario.getText().toString())) {
                    binding.etLoginUsuario.setError("Erro: informe o e-mail.");
                    binding.etLoginUsuario.requestFocus();
                    return;
                }
                if (!Validador.validaTexto(binding.etLoginSenha.getText().toString())) {
                    binding.etLoginSenha.setError("Erro: informe a senha.");
                    binding.etLoginSenha.requestFocus();
                    return;
                }

                // obtendo as informações
                String login = binding.etLoginUsuario.getText().toString();
                String senha = binding.etLoginSenha.getText().toString();

                // instanciando o objeto da classe
                Usuario usuario = new Usuario(login,senha);

                // chamando viewmodel
                mViewModel.efetuarLoginUsuario(usuario);


            }
        });
        binding.bLoginCancelar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                limpaCampos();
            }
        });
        binding.bLoginCadasroUsuario.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Navigation.findNavController(view).navigate(R.id.acao_LoginFragment_CadastroUsuarioFragment);
            }
        });
    }

    // observador para a autenticação do usuário
    Observer<Usuario> observaAuntenticacaoUsuario = new Observer<Usuario>() {
        @Override
        public void onChanged(Usuario usuario) {
            if (usuario != null) {
                // compartilhando usuario logado
                informacoesViewModel.inicializausuarioLogado(usuario);

                // chamando próxima tela
                Navigation.findNavController(requireView()).navigate(R.id.acao_LoginFragment_VisualizaEventosFragment);
            } else {
                Toast.makeText(getContext(), "Erro: Usuário e/ou senha inválidos!", Toast.LENGTH_SHORT).show();
            }

        }
    };

    public void limpaCampos() {
        binding.etLoginUsuario.setText("");
        binding.etLoginSenha.setText("");
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;

        // para funcionar corretamento o "voltar"
        // limpa estado do usuário logado
        mViewModel.limpaEstado();
    }

    @Override
    public void onResume() {
        super.onResume();
        // limpando os campos na tela quando "volta"
        limpaCampos();
        // escondendo a ToolBar e BottomNavigation
        if (requireActivity() instanceof MainActivity) {
            ((MainActivity) requireActivity()).escondeBottomNavigation();
            ((MainActivity) requireActivity()).getSupportActionBar().hide();
        }
    }

    @Override
    public void onStop() {
        super.onStop();
        // mostrando a ToolBar e BottomNavigation
        if (requireActivity() instanceof MainActivity) {
            ((MainActivity) requireActivity()).mostraBottomNavigation();
            ((MainActivity) requireActivity()).getSupportActionBar().show();
        }
    }
}



