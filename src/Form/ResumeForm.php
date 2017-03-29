<?php
/**
 * @file
 * Contains \Drupal\d8dev\Form\ResumeForm.
 */
namespace Drupal\d8dev\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ResumeForm extends FormBase 
{
  /**
   * {@inheritdoc}
   */
  public function getFormId() 
  {
    return 'resume_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) 
  {
    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Candidate Name:'),
      '#required' => TRUE,
    );
    $form['candidate_mail'] = array(
      '#type' => 'email',
      '#title' => t('Email ID:'),
      '#required' => TRUE,
    );
    $form['candidate_number'] = array (
      '#type' => 'tel',
      '#title' => t('Mobile no'),
    );
    $form['candidate_dob'] = array (
      '#type' => 'date',
      '#title' => t('DOB'),
      '#required' => TRUE,
    );
    $form['candidate_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'Female' => t('Female'),
        'male' => t('Male'),
      ),
    );
    $form['candidate_confirmation'] = array (
      '#type' => 'radios',
      '#title' => ('Are you above 18 years old?'),
      '#options' => array(
        'Yes' =>t('Yes'),
        'No' =>t('No')
      ),
    );
    $form['candidate_copy'] = array(
      '#type' => 'checkbox',
      '#title' => t('Send me a copy of the application.'),
    );

    //$terms = \Drupal\taxonomy\TermStorage::loadTree("classifica");
    $vid = "classifica";
    $parent = 0; $max_depth = NULL; $load_entities = FALSE;
    
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid, $parent, $max_depth, $load_entities);
    //$terms2 =\Drupal::service('entity_type.manager')->getStorage("taxonomy_term")->loadTree($vid, $parent = 0, $max_depth = NULL, $load_entities = FALSE);

    $options = array();
    foreach($terms  as $term) {
      $options[$term->tid] = $term->name;
    }

    //$categorie = db_query("SELECT tid, name FROM {taxonomy_term_field_data} WHERE vid = 'classifica'")->fetchAll();

    $form['classifica'] = array (
      '#type' => 'select',
      '#title' => ('Classifica'),
      '#default_value' => 9,
      '#options' => $options,
    );

    /*
    $form['classifica2'] = array(
      '#title' => 'La mia classifica',
      '#type' => 'taxonomy_term',
      '#vocabulary' => 'classifica',
      '#parent_tid' => 0,
      '#value_key' => 'tid',
    );
    */

    $form['actions']['#type'] = 'actions';
    
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    
    return $form;
  }

   /**
   * {@inheritdoc}
   */
    public function validateForm(array &$form, FormStateInterface $form_state) 
    {
		if (strlen($form_state->getValue('candidate_number')) < 10) {
			$form_state->setErrorByName('candidate_number', $this->t('Mobile number is too short.'));
		}
    }

   /**
   * {@inheritdoc}
   */
   public function submitForm(array &$form, FormStateInterface $form_state) 
   {
		// drupal_set_message($this->t('@can_name ,Your application is being submitted!', array('@can_name' => $form_state->getValue('candidate_name'))));
	    foreach ($form_state->getValues() as $key => $value) {
	      drupal_set_message($key . ': ' . $value);
	    }
   }
}
