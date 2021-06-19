interface NSpace extends NObject {
    id: string;
    name: string;
    settings: NSettings[];
    requests: NRequest[];
    proxyToUrl: string;
    useProxy: boolean;
}