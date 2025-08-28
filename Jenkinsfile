pipeline {
    // Define a Kubernetes pod as the agent for this pipeline
    agent {
        kubernetes {
            // Define the pod structure using YAML
            yaml """
apiVersion: v1
kind: Pod
spec:
  containers:
  - name: kubectl
    image: bitnami/kubectl:latest
    command:
    - sleep
    args:
    - 99d
"""
        }
    }

    stages {
        stage('Checkout') {
            steps {
                // This step will run inside the 'kubectl' container
                checkout scm
            }
        }

        stage('Deploy to Kubernetes') {
            steps {
                // 'kubectl' command is now available
                sh 'kubectl apply -f k8s-manifests/'
                echo 'Развертывание запущено. Ожидание 60 секунд для стабилизации подов...'
                sleep 60
            }
        }

        stage('Verify Database Connection') {
            steps {
                script {
                    echo "Проверка доступности базы данных..."
                    def appPodName = sh(script: "kubectl get pods -l app=crudback -o jsonpath='{.items[0].metadata.name}'", returnStdout: true).trim()
                    if (appPodName) {
                        sh "kubectl exec -it ${appPodName} -- bash -c \"timeout 10 bash -c '</dev/tcp/db/3306' && echo 'База данных MySQL доступна' || (echo 'Ошибка: база данных MySQL недоступна' && exit 1)\""
                    } else {
                        error "Под приложения не найден."
                    }
                }
            }
        }

        stage('Verify Frontend Availability') {
            steps {
                script {
                    echo "Проверка доступности веб-приложения..."
                    def externalIp = sh(script: "kubectl get svc crudback-service -o jsonpath='{.status.loadBalancer.ingress[0].ip}'", returnStdout: true).trim()
                    if (externalIp) {
                        echo "Приложение доступно по адресу: http://${externalIp}"
                        // We need curl for this check. Let's add it to the image or use a different one.
                        // For now, let's assume kubectl's image has it. A better image would be 'cgr.dev/chainguard/kubectl' which is small and secure.
                        sh "kubectl run curl-test --image=curlimages/curl:latest --rm -it --restart=Never -- curl --fail --silent http://${externalIp} || (echo 'Ошибка: веб-приложение недоступно по внешнему IP' && exit 1)"
                    } else {
                        error "Внешний IP для сервиса crudback-service не найден."
                    }
                }
            }
        }
    }
    post {
        success {
            echo 'Сборка успешно завершена!'
        }
        failure {
            echo 'Сборка провалена.'
        }
    }
}
