import HttpClient from "@/providers/http-client";
import {AxiosRequestConfig} from "axios";

export class PhpHubApi extends HttpClient {
    public getListPhpInstances() {
        return this.get('/api/v1/php-instances')
    }

    public postCodeToRunner(runUrl: string, code: string) {
        return this.post('/api/v1' + runUrl, {
            code: code
        })
    }

    protected beforeRequest(config: AxiosRequestConfig): AxiosRequestConfig {
        config.baseURL = process.env.VUE_APP_MAIN_HOST_URL;

        return config;
    }
}