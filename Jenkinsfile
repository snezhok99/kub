pipeline {
  agent {
    kubernetes {
      yamlFile 'builder.yaml'
    }
  }

  environment {
    NAMESPACE = "crud"
  }

  stages {

    stage('Checkout Code') {
      steps {
        checkout scm
      }
    }

    stage('Test Database') {
      steps {
        container('kubectl') {
          script {
            echo 'Проверяем доступ к базе данных через сервис...'
            // Проверяем, что сервис mysql-master доступен на порту 3306
            // Если недоступен — команда вернёт ненулевой код выхода
            sh """
              timeout 5 bash -c 'echo > /dev/tcp/$(kubectl get svc mysql-master -n ${NAMESPACE} -o jsonpath='{.spec.clusterIP}')/3306'
            """
          }
        }
      }
    }

    stage('Test Frontend') {
      steps {
        container('kubectl') {
          script {
            echo 'Тестируем фронтенд...'
            sh 'curl -f http://crudback-service.${NAMESPACE}.svc.cluster.local:8080/  exit 1'
          }
        }
      }
    }

    stage('Deploy App to Kubernetes') {
      steps {
        container('kubectl') {
          withCredentials([file(credentialsId: 'kubeconfig-secret-id', variable: 'KUBECONFIG')]) {
            sh 'kubectl create ns ${NAMESPACE}  true'
            sh 'kubectl apply -f ./manifests -n ${NAMESPACE}'
          }
        }
      }
    }
  }
}
