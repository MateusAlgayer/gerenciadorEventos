package com.example.jubileueventos.retrofit;

import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class ClienteRetrofit {

    public static Retrofit getInstance() {
        String ip = "10.0.0.157";
        String urlWebService = "http://" + ip + "/gerenciadorEventos/api/";

        // adicionando as possibilidades de debugar e interceptar mensagens (OPCIONAL)
        HttpLoggingInterceptor loggingInterceptor = new HttpLoggingInterceptor();
        loggingInterceptor.setLevel(HttpLoggingInterceptor.Level.BODY);
        OkHttpClient.Builder httpClient = new OkHttpClient.Builder();
        httpClient.addInterceptor(loggingInterceptor);

        Retrofit retrofit = new Retrofit.Builder()
                                        .baseUrl(urlWebService)
                                        .addConverterFactory(GsonConverterFactory.create())
                                        .client(httpClient.build())
                                        .build();
        return retrofit;
    }
}
