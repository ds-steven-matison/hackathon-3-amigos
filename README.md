# Hackathon 3 Amigos

## Create your own dockerhub image

Current Docker [image](https://hub.docker.com/repository/docker/dsstevenmatison/tres-amigos). 

1. Git clone [this repo]
2. Next build and push image
```
docker build . -t dsstevenmatison/tres-amigos
docker push dsstevenmatison/tres-amigos
```
:warning: This sample above is mine, you would change to your dockerhubrepo/appname.  Then in the deployment.k8s.yaml file you reference the full docker.io string to image.  For example: <b></i>docker.io/dsstevenmatison/tres-amigos:latest</i></b>.

3. Edit deployment.k8s.yaml accordingly then
```
kubectl apply -f deployment.k8s.yaml
```
4. If you are just updating the image, murder the pod and it will recreate w/ new image
```
kubectl delete pod tres-amigos-6c6cd5c6d6-qlxhb
```
:bulb: Monitor your <b></i>watch kubectl get pods</i></b> terminal and watch this pod terminate and recreate!!!

## Access app locally

```
kubectl port-forward deployments/tres-amigos  1337:80
```
After port fwd access app @ [http://localhost:1337](http://localhost:1337).

## Connect to app container

```
kubectl exec -it deployments/tres-amigos /bin/bash
```
:bulb: Use the command <b></i>tail -f /var/log/php5-fpm.log</i></b> to check PHP Errors.  You can also find the app source at <b></i>/usr/share/nginx/html</i></b>.


## Cluster should look like

```
NAME                                                READY   STATUS    RESTARTS   AGE
k8ssandra-kube-prometheus-operator-85695ffb-rx6tj   1/1     Running   0          81m
k8ssandra-reaper-operator-b67dc8cdf-cxntz           1/1     Running   0          81m
prometheus-k8ssandra-kube-prometheus-prometheus-0   2/2     Running   1          81m
k8ssandra-cass-operator-7c876d6d96-ls2pv            1/1     Running   0          81m
k8ssandra-grafana-5c6d5b8f5f-gb2hg                  2/2     Running   0          81m
k8ssandra-dc1-default-sts-0                         2/2     Running   0          80m
k8ssandra-dc1-stargate-77d4985d67-s69xd             1/1     Running   0          81m
k8ssandra-reaper-655fc7dfc6-jcf7p                   1/1     Running   0          76m
tres-amigos-6c6cd5c6d6-hrmsx                        1/1     Running   0          44m
```