pipeline {

  agent {
    kubernetes {
      yamlFile 'builder.yaml'
    }
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
            echo 'Проверяем доступ к базе данных...'
            // Проверка TCP на MySQL (работает в BusyBox)
            def dbHost = '10.40.0.2'
            def dbPort = 3306
            def result = sh(
              script: "timeout 5 sh -c 'echo > /dev/tcp/${dbHost}/${dbPort}'",
              returnStatus: true
            )
            if (result != 0) {
              error "База данных недоступна!"
            } else {
              echo "База доступна ✅"
            }
          }
        }
      }
    }

    stage('Test Frontend') {
      steps {
        container('kubectl') {
          script {
            echo 'Проверяем доступ к фронтенду...'
            def frontendUrl = 'http://192.168.0.100:80'
            def result = sh(
              script: "curl -sSf ${frontendUrl}",
              returnStatus: true
            )
            if (result != 0) {
              error "Фронтенд недоступен!"
            } else {
              echo "Фронтенд доступен ✅"
            }
          }
        }
      }
    }

    // Этот блок деплоя оставляем полностью без изменений
    stage('Deploy App to Kubernetes') {
      steps {
        container('kubectl') {
          withCredentials([file(credentialsId: 'kubeconfig-secret-id', variable: 'KUBECONFIG')]) {
            sh 'kubectl create ns crud || true'
            sh 'kubectl apply -f ./manifests -n crud'
          }
        }
      }
    }

  }
}
